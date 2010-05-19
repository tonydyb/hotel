<?php

echo "<select name='data[City][id]' id='cities'>";

if(!empty($options)) {
  foreach($options as $k => $v) {
    echo "<option value='$k'>$v</option>";
  }
}

echo "</select>";

?>