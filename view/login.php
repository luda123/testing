<html>
<head>
  <link rel="stylesheet" href="/css/chosen.css">
  <script src="/js/jquery-3.2.1.min.js" type="text/javascript"></script>
  <script src="/js/chosen.jquery.js" type="text/javascript"></script>
  <script src="/js/functions.js" type="text/javascript"></script>

  <style>
  .input-field.error textarea, .input-field.error input ,.input-field.error a.chosen-single{
    border: 1px solid #d70027 !important;
  }
  </style>
</head>
<body>
<a href="javascript:void(0);"  id="lnk_out">Выход</a>
<h1>Личный кабинет</h1>
<form action="" method=”POST” class="js_validate" role="form">
<p>
<label>ФИО</label>
<div class="input-field">
<input id="username" value="<?=$user[0]['name'];?>" name="username" type="text" />
</div>
</p>
<p>
<label>Email</label>
<div class="input-field">
<input id="email" name="email" type="email" value="<?=$user[0]['email'];?>"/>
</div>
</p>

<p>
<label>Область</label>
<div class="input-field">
<select data-placeholder_="Выберите область" class="chosen-select" id="sel_reg" name="sel_reg" required="required">
             <option value="">Выберите область</option>
    <?php for($i=0;$i<count($regs);$i++) { ?>
             <option value="<?=$regs[$i]["ter_id"];?>" <?php if($reg[0]['ter_id']==$regs[$i]["ter_id"]) echo selected; ?> ><?=$regs[$i]["ter_name"];?></option>
    <?php } ?>  
</select>
</div>

<p>
<label>Город</label>
<div class="input-field">
 <select data-placeholder="Выберите город" class="chosen-select" id="sel_city" name="sel_city" required="required">
       <?php for($i=0;$i<count($cities);$i++) { ?>
             <option value="<?=$cities[$i]["ter_id"];?>" <?php if($cities[$i]['ter_id']==$city) echo selected; ?> ><?=$cities[$i]["ter_name"];?></option>
       <?php } ?>  
 </select>
 </div>
</p> 

<p>
<label>Район</label>
<div class="input-field">
 <select data-placeholder="Выберите район" class="chosen-select" id="sel_distr" name="sel_distr" required="required">
      <?php for($i=0;$i<count($districts);$i++) { ?>
             <option value="<?=$districts[$i]["ter_id"];?>" <?php if($distr==$districts[$i]["ter_id"]) echo selected; ?> ><?=$districts[$i]["ter_name"];?></option>
       <?php } ?>  
 </select>
 </div>

</p>

<p>
   <input type="hidden" value="" name="user_id" id="user_id"/>
   <!--<button type="submit" ><span>Сохранить</span></button> <button type="reset"><span>Отменить</span></button>-->
</p>
</form>

</body>
</html>