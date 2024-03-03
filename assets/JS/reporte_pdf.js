function generarInformePDF(action) {
  let url = 'actions/'+ action;
  // Lógica para abrir una nueva ventana o pestaña con el archivo PDF
  window.open(url, "_blank");
}