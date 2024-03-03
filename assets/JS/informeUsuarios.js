function informeUsuarios() {
// Deshabilitar el enlace si no hay datos
document.getElementById("pdfLink").setAttribute("href", "javascript:void(0);");
 
        document.getElementById("pdfLink").setAttribute("href", "actions/reporteUsuariosPDF.php");
          

}