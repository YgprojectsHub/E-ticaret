import smtp from "../js/smtp.js";

export function sendEmail(name, email, subject, message){
    let newbody = name +" Adlı bayi : " + " Email : " + email + " Mesajı : " + message;
    smtp.Email.send({
      Host: "smtp.elasticemail.com", 
      Username: "sftwaretests@gmail.com",
      Password: "72CD608B77BBA08F808B1C38C8D81EE09A0F",
      To: "homecargo34@gmail.com",
      From: "sftwaretests@gmail.com",
      Subject: `${subject}`,
      Body: `${newbody}`,
    })
  }