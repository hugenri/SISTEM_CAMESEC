<?php

class ResponseJson{

function handle_response_json($success, $message) {
  $response = ['success' => $success, 'message' => $message];
  echo json_encode($response);
  exit();
}
function response_json($response) {
  echo json_encode($response);
  exit();
}

}