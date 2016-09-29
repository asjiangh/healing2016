<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Token</title>
    <script src="/js/localdb.js"></script>
</head>
<body>
<p>Your Token:</p>
<p>{{ $token }}</p>
<script>
    window.localStorage.healing2016_token = '{{ $token }}';
    var db = new LocalDB("Token",{
        expire: 'none',
        encrypt: true,
        proxy: 'http://repo.gayhub.cn/'
    });
    var token = db.collection("token");
    token.insert({toekn:'{{ $token }}',name:'token'}).then(function(err){
        console.log(err);
    });
    setTimeout(function () {
        window.location.href = 'http://repo.gayhub.cn/core/mynode/sundoge/token.html';
    }, 3000);

</script>
</body>
</html>