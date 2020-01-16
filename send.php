<?php
$fio = $_POST['fio'];
$email = $_POST['email'];
$service = $_POST['service'];
$phonenumber = $_POST['phonenumber'];

$fio = htmlspecialchars($fio);
$email = htmlspecialchars($email);
$service = htmlspecialchars($service);
$phonenumber = htmlspecialchars($phonenumber);

$fio = urldecode($fio);
$email = urldecode($email);
$service = urldecode($service);
$phonenumber = urldecode($phonenumber);

$fio = trim($fio);
$email = trim($email);
$service = trim($service);
$phonenumber = trim($phonenumber);

//echo $fio;
//echo "<br>";
//echo $email;
//echo "<br>";
//echo $service;
//echo "<br>";
//echo $phonenumber;

mail("fop.ivaniuk.oleksii@gmail.com", "Заявка з сайту", "ФІО:".$fio.". E-mail: ".$email. "НОМЕР": ".$phonenumber . ПОСЛУГА: ".$service ,"From: example2@mail.ru \r\n");
 
if (mail("fop.ivaniuk.oleksii@gmail.com", "Заявка з сайту", "ФІО:".$fio.". E-mail: ".$email. "НОМЕР": ".$phonenumber . ПОСЛУГА: ".$service ,"From: example2@mail.ru \r\n"))
{ 
echo "повідомлення відправлено успішно";
} else {
    echo "при відправлені виникла проблема, повторіть ще раз";
}