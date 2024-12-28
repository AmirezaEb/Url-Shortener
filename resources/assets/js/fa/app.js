const token="503bf5006708dc769617c571f07206858ef8c018";const button=document.querySelector(".shortenURL");const input=document.querySelector("#input-field");const longUrl=document.querySelector("#input-url");const shortUrl=document.querySelector("#new-url");const urlDetail=document.querySelector('#new-url a')
const resultDiv=document.querySelector("#output-div")
const errorDiv=document.querySelector("#error-div");const errorMessage=document.querySelector("#error-text");const clearButton=document.querySelector("#clear-btn");const copyButton=document.querySelector("#copy-btn");const handleError=(response)=>{console.log(response);if(!response.ok){errorMessage.textContent=""
hideResult();}else{return response;}}
const shorten=(input)=>{fetch("https://api-ssl.bitly.com/v4/shorten",{method:"POST",headers:{"Authorization":`Bearer ${token}`,"Content-Type":"application/json"},body:JSON.stringify({"long_url":input,"domain":"bit.ly"})}).then(handleError).then(response=>response.json()).then((json)=>{shortUrl.innerHTML=json.link;showResult();}).catch(error=>{console.log(error);})}
const clearFields=()=>{input.value='';hideResult();}
clearButton.addEventListener("click",(event)=>{event.preventDefault();clearFields();window.location.href='./'})
copyButton.addEventListener('click',event=>{event.preventDefault()
navigator.clipboard.writeText(urlDetail.innerHTML)
if(urlDetail.innerHTML){Swal.fire({title:'لینک کوتاه شما با موفقیت کپی شد!',icon:'success',toast:true,position:'top-end',showConfirmButton:false,timer:3500,timerProgressBar:true,didOpen:(toast)=>{toast.onmouseenter=Swal.stopTimer;toast.onmouseleave=Swal.resumeTimer;}})}})
const showResult=()=>{shortUrl.style.display="flex";}
const hideResult=()=>{shortUrl.style.display='none';}

if (input) {
    input.addEventListener('keyup', event => {
        if (input.value.length >= 1) {
            input.classList.add('input-left')
        } else {
            input.classList.remove('input-left')
        }
    })
}

/* 
Developed by Hero Expert 
Telegram channel: @HeroExpert_ir
*/
