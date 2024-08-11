<script>
    function postSamanRefId(Token, Url) {

        var form = document.createElement("form");
        form.setAttribute("method", "POST");
        form.setAttribute("action", Url);
        form.setAttribute("target", "_self");
        var hiddenField = document.createElement("input");
        hiddenField.setAttribute("name", "Token");
        hiddenField.setAttribute("value", Token);
        form.appendChild(hiddenField);

        document.body.appendChild(form);
        form.submit();
        document.body.removeChild(form);
    }
</script>
