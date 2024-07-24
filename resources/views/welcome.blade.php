<form id="form">

</form>
<script>

    var form = document.getElementById("form");
    form.setAttribute("method", "POST");
    form.setAttribute("action", "{{$url}}");
    form.setAttribute("target", "_self");
    var hiddenField = document.createElement("input");
    hiddenField.setAttribute("name", "Token");
    hiddenField.setAttribute("value", "{{$token}}");
    form.appendChild(hiddenField);
    document.body.appendChild(form);
    form.submit();
    document.body.removeChild(form);

</script>
