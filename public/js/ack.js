AccountKit_OnInteractive = function() {
  AccountKit.init({
    appId: '247889412789181',
    state: document.getElementById('_token').value,
    version: 'v1.1',
    fbAppEventsEnabled:true,
  });
};

function loginCallback(response) {


  if (response.status === "PARTIALLY_AUTHENTICATED") {
    document.getElementById('code').value = response.code;
    document.getElementById('_token').value = response.state;
    document.getElementById('form').submit();
  }

  else if (response.status === "NOT_AUTHENTICATED") {
      // handle authentication failure
      alert('Đăng nhập không thành công vui lòng đăng nhập lại');
  }
  else if (response.status === "BAD_PARAMS") {
    // handle bad parameters
    alert('wrong inputs');
  }
} 
function smsLogin() {
  // var countryCode = document.getElementById('country').value;
  // var phoneNumber = document.getElementById('phone').value;
  AccountKit.login(
    'PHONE',
    {countryCode: '+84', phoneNumber: ''},
    loginCallback
  );
}
// email form submission handler
function emailLogin() {
  var emailAddress = document.getElementById("email").value;
  AccountKit.login('EMAIL', {emailAddress: emailAddress}, loginCallback);
}
