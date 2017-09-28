/**
 * Created by PC on 23-Sep-17.
 */

$('#promeniSliku').on('change', function() {
    $('#myImg').attr('src',window.URL.createObjectURL(this.files[0]));
});
