<?php

namespace App\Imports;

use App\Book;
use App\TypeBook;
use App\Field;
use App\Category;
use App\Producer;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow; // khai báo để select theo cột trong excel
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithValidation;

use Maatwebsite\Excel\Concerns\WithBatchInserts; //Định lượng số lượng dòng insert vào 1 lần
use Maatwebsite\Excel\Concerns\WithChunkReading; //Định lượng số lượng dòng được nạp vào bộ nhớ 

class ImportBook implements ToModel, WithHeadingRow, WithValidation, WithBatchInserts, WithChunkReading
{
    use Importable;

    public function headingRow(): int
    {
        return 1;
    }
    public function __construct(){
        set_time_limit(0);
        ini_set('memory_limit', '2000M');
    }
    public function rules(): array  //Validation
    {
        return [
            'macty'     => 'required',
            'loaisach'  => 'required',
            'theloai'   => 'required',
            'linhvuc'   => 'required',
            'masach'    => 'nullable',
            'tensach'   => 'required',
            'tacgia'    => 'nullable',
            'nxb'       => 'required',
            'namxb'     => 'integer|nullable',
            'trang'     => 'integer|nullable',
            'kichthuoc' => 'nullable',
            'gia'       => 'integer',
            'nguoitao'  => 'required',
            'nguon'     => 'nullable',
        ];
    }
    public function customValidationMessages()
    {
        return [
            'macty.required'     =>  'Bạn chưa nhập macty',
            'loaisach.required'  =>  'Bạn chưa nhập loại sách',
            'theloai.required'   =>  'Bạn chưa nhập thể loại',
            'linhvuc.required'   =>  'Bạn chưa nhập lĩnh vực',
            'masach.nullable'    =>  'Mã sách không đúng',
            'tensach.required'   =>  'Bạn chưa nhập tên sách',
            'tacgia.nullable'    =>  'Tác giả không đúng',
            'nxb.required'       =>  'Bạn chưa nhập nhà xuất bản',
            'namxb.integer'      =>  'Năm xuất bản phải là số',
            'trang.integer'      =>  'Số trang phải là số',
            'kichthuoc.nullable' =>  'Kích thước không đúng',
            'gia.integer'        =>  'Giá phải là số',
            'nguoitao.required'  =>  'Bạn chưa nhập người tạo',
            'nguon.nullable'     =>  'Nguồn không đúng',
        ];
    }
    public function model(array $row)
    {  
        //Convesrt to symbol
        $loaisach =   $this->ConvesrtEng($row['loaisach']);
        $linhvuc  =   $this->ConvesrtEng($row['linhvuc']);
        $theloai  =   $this->ConvesrtEng($row['theloai']);
        $nxb      =   $this->ConvesrtEng($row['nxb']);

        $type_book       =   [];
        $category        =   [];        
        //Loai sách 
            $temp    = TypeBook::firstOrCreate(['symbol' => $loaisach],[
                'symbol' =>  $loaisach,
                'name'   =>  $row['loaisach'],
                'status' =>  1,
            ]);
            array_push($type_book,$temp->symbol);
        //Tạo thể loại
            $temp = Category::firstOrCreate(['symbol' => $theloai],[
                'type_book'     =>  $type_book[0],
                'symbol'        =>  $theloai,
                'name'          =>  $row['theloai'],
                'status'        =>  1,
            ]);
            array_push($category,$temp->symbol);
        //Tạo lĩnh vực
            $temp = Field::firstOrCreate(['symbol' => $linhvuc],[
                'category'      =>  $category[0],
                'symbol'        =>  $linhvuc,
                'name'          =>  $row['linhvuc'],
                'status'        =>  1,
            ]);
        //Tạo nhà xuất bản
            $temp = Producer::firstOrCreate(['symbol' => $nxb],[
                'symbol'        =>  $nxb,
                'name'          =>  $row['nxb'],
                'status'        =>  1,
            ]);
        //Tạo Sách
            Book::firstOrCreate(['macty' => $row['macty']],[
                'macty'         =>  $row['macty'],
                'type_book'     =>  $loaisach,
                'field'         =>  $linhvuc,
                'category'      =>  $theloai,
                'book_code'     =>  $row['masach'],
                'name'          =>  $row['tensach'],
                'author'        =>  $row['tacgia'],
                'producer'      =>  $nxb,
                'producer_year' =>  $row['namxb'],
                'page'          =>  $row['trang'],
                'size'          =>  $row['kichthuoc'],
                'price'         =>  $row['gia'],
                'creator'       =>  $row['nguoitao'],
                'link'          =>  $row['nguon'],
                'status'        =>  1,
            ]);
    }
    public function batchSize(): int
    {
        return 20;
    }

    public function chunkSize(): int
    {
        return 2000;
    }

     //hàm convesrt sang không dấu, loại bỏ khoảng trắng, upcase
    public function ConvesrtEng($str) {
        $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);
        $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);
        $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);
        $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);
        $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);
        $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);
        $str = preg_replace("/(đ)/", 'd', $str);

        $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);
        $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);
        $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);
        $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);
        $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);
        $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);
        $str = preg_replace("/(Đ)/", 'D', $str);

        $str = str_replace(' ', '', $str);  //loại bỏ khoảng trắng
        $str = strtoupper($str);    // UpCase
        return $str;
    }
}
