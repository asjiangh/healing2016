<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Test Token</title>
    <script>
        window.onload=function(){
            window.frames[0].postMessage('{{ $token }}','http://repo.gayhub.cn');
        }
    </script>
</head>
<body>
<p>Your Token:</p>
<p>{{ $token }}</p>
<iframe src="http://repo.gayhub.cn/core/mynode/sundoge/token.html" frameborder="0"></iframe>
</body>
</html>