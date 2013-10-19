<h2>Facebook Register Result</h2>
<img src="https://graph.facebook.com/<?php echo $fb;?>/picture?width=150" alt="" />
 
<h2>Friends</h2>
<?php for($i = 0; $i < count($friends['data']); $i++):?>
    <?php if($me['gender'] != $friends['data'][$i]['gender']):?>
        <a href="https://www.facebook.com/<?php echo $friends['data'][$i]['id'];?>">
            <img src="https://graph.facebook.com/<?php echo $friends['data'][$i]['id'];?>/picture?width=100&height=100" alt="" />
        </a>
    <?php endif;?>
<?php endfor;?>
