// file: alertmessage.js
const alertDiv1=document.querySelector("#alert-div1"),alertMessage1=document.querySelector("#alert-message1"),alertDiv2=document.querySelector("#alert-div2"),alertMessage2=document.querySelector("#alert-message2");
/*
showSuccessAlert1("message", true); // Remove danger message of previously showing and change it to success
showDangerAlert2("message", false); // Remove success message of previously showing and change it to danger
*/
// using showSuccessAlert1 is for success
const showSuccessAlert1=(e,s=!1,duration=5000)=>{alertDiv1.classList.remove("no-content"),alertDiv1.classList.remove(s?"alert-danger":"alert-success"),alertDiv1.classList.add(s?"alert-success":"alert-danger"),alertMessage1.textContent=e,setTimeout((()=>{alertDiv1.classList.add("no-content")}),duration)};
// using showDangerAlert2 is for danger
const showDangerAlert2=(e,t=!1)=>{alertDiv2.classList.remove("no-content"),alertDiv2.classList.remove(t?"alert-danger":"alert-success"),alertDiv2.classList.add(t?"alert-success":"alert-danger"),alertMessage2.textContent=e,setTimeout((()=>{alertDiv2.classList.add("no-content")}),2e3)};""===alertMessage1.innerHTML.trim()&&alertDiv1.classList.add("no-content"),""===alertMessage2.innerHTML.trim()&&alertDiv2.classList.add("no-content");