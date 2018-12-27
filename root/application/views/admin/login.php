<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>Авторизация</title>
	<link href="/public/style.css" rel="stylesheet" type="text/css" />
	<link href="/public/jquery-ui-1.11.4/jquery-ui.css" rel="stylesheet" />
	<script src="/public/jquery.js"></script>
	<script src="/public/jquery-ui-1.11.4/jquery-ui.js"></script>
	<script>
	$(function() {
		$("#dialog").dialog({
			autoOpen: true,
			resizable: false,
			draggable: false,
			buttons: [
				{
					text: "Ok",
					click: function() {
						$("#loginForm").submit();
					}
				}
			],
			close: function(event, ui) {
				$(this).dialog("open");
			}
		});
	});
	</script>
</head>

<body>

<div id="dialog" title="Авторизация">
    <form action="/admin/login" method="post" name="loginForm" id="loginForm">
        	<table width="100%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <th scope="row">Логин:</th>
                <td><input name="fldLogin" type="text" /></td>
              </tr>
              <tr>
                <th scope="row">Пароль:</th>
                <td><input name="fldPassword" type="password" /></td>
              </tr>
            </table>
    </form>
</div>

</body>
</html>
