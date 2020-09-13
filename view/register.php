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
<?php
echo $reslt;
?>
<h1>Регистрация</h1>
<form action="" method=”POST” class="js_validate" role="form">
<p>
<label>ФИО</label>
<div class="input-field">
<input id="username" value="" name="username" type="text" required="required" />
</div>
</p>
<p>
<label>Email</label>
<div class="input-field">
<input id="email" name="email" type="email" required="required" data-validate="email" value=""/>
</div>
</p>

<p>Список областей</p>
<div class="input-field">
<select data-placeholder_="Выберите область" class="chosen-select" id="sel_reg" name="sel_reg" required="required">
             <option value="">Выберите область</option>
    <?php for($i=0;$i<count($regs);$i++) { ?>
             <option value="<?=$regs[$i]["ter_id"];?>"><?=$regs[$i]["ter_name"];?></option>
    <?php } ?>  
</select>
</div>

<p>Список городов</p>
<div class="input-field">
 <select data-placeholder="Выберите город" class="chosen-select" id="sel_city" name="sel_city" required="required">
      <option value=""></option>
 </select>
 </div>
<p>Список районов</p>
<div class="input-field">
 <select data-placeholder="Выберите район" class="chosen-select" id="sel_distr" name="sel_distr" required="required">
      <option value=""></option>
 </select>
 </div>
          
  <br />
<p>
   <input type="hidden" value="" name="user_id" id="user_id"/>
   <button type="submit" ><span>Сохранить</span></button> <button type="reset"><span>Отменить</span></button>
</p>
</form>

<script>
 $(".chosen-select").chosen({no_results_text: "Oops, nothing found!"}); 
</script>
</body>
</html>
