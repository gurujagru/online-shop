/**
 * Created by PC on 24-Sep-17.
 */

$("#registracija").click(function(){
    $("#signup").load("http://online-shop.org/site/signup");
});
$("#tabelaId").click(function(){
    var content = document.getElementById("tabelarka");
    var pri = document.getElementById("zaStampu").contentWindow;
    pri.document.open();
    pri.document.write(content.innerHTML);
    pri.document.close();
    pri.focus();
    pri.print();
});
$("#download").click(function() {
    var a = document.body.appendChild(
        document.createElement("a")
    );
    a.download = "otpremnica.html";
    a.href = "data:text/html," + document.getElementById("tabelarka").innerHTML;
    a.click();
});