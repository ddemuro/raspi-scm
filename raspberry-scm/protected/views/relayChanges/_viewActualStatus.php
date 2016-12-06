<?php
/* @var $this RelayChangesController */
/* @var $data RelayChanges */
?>

<div class="view">

    <b>
        <br>
        <?php for ($i = 0; $i < count($status); $i++): ?>
            <?php
            $value = ($status[$i] === 1 ? "checked" : "unchecked");
            $toset = ($status[$i] === 1 ? 0 : 1);
            $relayNumber = $i+1;
            if ($i < count($relayInfo)) {
                $relay = $relayInfo[$i];
                if (isset($relay)) {
                    $img = Yii::app()->theme->baseUrl.'/img/'.$relay->setting.'.jpg';
                    $extended = "- Type: $relay->setting - $relay->extended status";
                }
            } else {
                $extended = "";
                $img = "";
            }
            
            ?>
            <div><?php echo "Relay $relayNumber $extended:" ?>
                <img style="max-width: 50px; height: auto;"src=<?php echo $img; ?>></a>
                <div class="onoffswitch">
                    <input onchange="relaychange(<?php echo "$relayNumber" ?>)" type="checkbox" name="onoffswitch" class="onoffswitch-checkbox" id="myonoffswitch<?php echo $relayNumber; ?>" <?php echo $value ?>>
                    <label class="onoffswitch-label" for="myonoffswitch<?php echo $relayNumber; ?>">
                        <span class="onoffswitch-inner"></span>
                        <span class="onoffswitch-switch"></span>
                    </label>
                </div>
            </div>
            <br>
<?php endfor; ?>
    </b>

</div>
<script type="text/javascript">
     function relaychange(i) {
        status = document.getElementById("myonoffswitch"+i).checked == true ? 1 : 0;
        $.get("ChangeRelay?id="+i+"&"+"status="+status, function(data, status){
            alert("Data: " + data + "\nStatus: " + status);
        });
     }
 </script>
