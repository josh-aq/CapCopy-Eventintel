<?php require_once __DIR__ . '/../../config/db.php'; require_role('client');
$event_id=intval($_GET['id']??0);
$ev=db()->prepare("SELECT * FROM events WHERE event_id=? AND user_id=?"); $ev->execute([$event_id,$_SESSION['user_id']]); $event=$ev->fetch();
if(!$event){ header('Location: yourevents.php'); exit; }
if($_SERVER['REQUEST_METHOD']==='POST'){
    $bg=null;
    if(isset($_FILES['background']) && $_FILES['background']['error']===UPLOAD_ERR_OK){
        $name='invitations/bg_'.uniqid().'.'.pathinfo($_FILES['background']['name'],PATHINFO_EXTENSION);
        move_uploaded_file($_FILES['background']['tmp_name'], __DIR__.'/../../uploads/'.$name);
        $bg='uploads/'.$name;
    }
    $exists=db()->prepare("SELECT invitation_id FROM invitations WHERE event_id=?"); $exists->execute([$event_id]);
    if($exists->fetch()){
        $sql="UPDATE invitations SET title=?, message=?, theme_color=?, font_style=?, button_text=?".($bg?", background_image=?":"")." WHERE event_id=?";
        $params=[$_POST['title'],$_POST['message'],$_POST['theme_color'],$_POST['font_style'],$_POST['button_text']];
        if($bg)$params[]=$bg; $params[]=$event_id; db()->prepare($sql)->execute($params);
    }else{
        db()->prepare("INSERT INTO invitations(event_id,title,message,theme_color,font_style,button_text,background_image) VALUES(?,?,?,?,?,?,?)")
        ->execute([$event_id,$_POST['title'],$_POST['message'],$_POST['theme_color'],$_POST['font_style'],$_POST['button_text'],$bg]);
    }
}
$inv=db()->prepare("SELECT * FROM invitations WHERE event_id=?"); $inv->execute([$event_id]); $inv=$inv->fetch() ?: ['title'=>"You're Invited",'message'=>'Please RSVP','theme_color'=>'#f3c547','font_style'=>'Segoe UI','button_text'=>'Confirm RSVP','background_image'=>null];
$link="/EVENTINTELmayAPI/userui/html/rsvp.php?event=".$event_id;
?><!DOCTYPE html><html><head><title>Edit Invitation</title><style>body{background:#050505;color:white;font-family:Segoe UI;padding:30px}.wrap{display:grid;grid-template-columns:1fr 1fr;gap:25px}.card{background:#111;border:1px solid rgba(255,215,0,.25);border-radius:24px;padding:25px}input,textarea,select{width:100%;padding:12px;margin:8px 0;border-radius:12px;background:#181818;color:white;border:1px solid #333}.btn{padding:12px 18px;border-radius:12px;border:0;background:linear-gradient(135deg,#fff1a8,#f3c547,#c98f08);font-weight:700}.preview{min-height:430px;background:#151515;border-radius:24px;padding:30px;text-align:center;background-size:cover;background-position:center}</style></head><body>
<a style="color:#f3c547" href="yourevents.php">← Back</a><h1>Editable RSVP Invitation</h1>
<div class="wrap"><form class="card" method="POST" enctype="multipart/form-data">
<label>Invitation Title</label><input name="title" value="<?=esc($inv['title'])?>">
<label>Message</label><textarea name="message"><?=esc($inv['message'])?></textarea>
<label>Theme Color</label><input type="color" name="theme_color" value="<?=esc($inv['theme_color'])?>">
<label>Font</label><select name="font_style"><option>Segoe UI</option><option>Georgia</option><option>Arial</option></select>
<label>RSVP Button Text</label><input name="button_text" value="<?=esc($inv['button_text'])?>">
<label>Background Image</label><input type="file" name="background" accept="image/*">
<button class="btn">Save Template</button></form>
<div class="card"><h2>Preview / Share</h2><div class="preview" style="font-family:<?=esc($inv['font_style'])?>;background-image:url('/EVENTINTELmayAPI/<?=esc($inv['background_image'])?>')"><h1 style="color:<?=esc($inv['theme_color'])?>"><?=esc($inv['title'])?></h1><p><?=nl2br(esc($inv['message']))?></p><button class="btn"><?=esc($inv['button_text'])?></button></div><p>Guest link: <a style="color:#f3c547" href="<?=$link?>"><?=$link?></a></p></div></div></body></html>