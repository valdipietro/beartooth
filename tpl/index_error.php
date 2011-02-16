<?php
if( !isset( $result_array ) || !is_array( $result_array ) )
{
  $code = \sabretooth\util::convert_number_to_code( UNKNOWN_BASE_ERROR_NUMBER );
  $result_array = array( 'error_type' => 'Unknown',
                         'error_code' => $code,
                         'error_message' => '' );
}

// set template variables
$type = $result_array['error_type'];
$notice = 0 < strlen( $result_array['error_message'] )
        ? $result_array['error_message']
        : 'There was an error while trying to communicate with the server.<br>'.
          'Please notify a supervisor with the error code.';
$code = substr( $result_array['error_type'], 0, 1 ).'.'.$result_array['error_code'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
  <title>Sabretooth</title>
  <link href="css/main.css" rel="stylesheet" />
  <style type="text/css">
    body { margin: 10px; }
    div { padding: 10px; }
    div.error { width: 500px; border: 2px solid red; }
    h2 { margin: 0px; color: red; }
  </style>
</head>

<body>

<div class="error">
  <h2><?php echo $type; ?> Error!</h2>
  <div>
    <p><?php echo $notice; ?></p>
    <p class="error_code">Error code: I.<?php echo $code; ?></p>
  </div>
</div>

</body>