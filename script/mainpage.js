const confirmButton=document.getElementById("confirm"),investMoneyTextElement=document.getElementById("investMoneyText");var welfareButton=document.querySelector(".card-body button");
function purchase(){const e=event.target.closest(".card.mb-4"),t=e.querySelector(".card-title"),n=t?t.textContent:"",c=e.querySelector(".card-text"),o=c?c.innerHTML:"",r=o.match(/Invest Money: ₹(\d+(,\d+)*)/),m=o.match(/Income Daily: ₹(\d+(,\d+)*)/),a=o.match(/Income Days: (\d+)/),d=o.match(/Gift: VIP Level (\d+)/),i=o.match(/Requirement: VIP Level (\d+)/);return{cardTitleText:n,investMoney:r?r[1]:"",incomeDaily:m?m[1]:"",incomeDays:a?a[1]:"",gift:d?d[1]:"",reqgift:i?i[1]:""}}
function stable(){const e=document.getElementById("confirm"),t=document.getElementById("investMoneyText"),n=document.getElementById("free-card");e.disabled=!0,t.textContent="";const o=purchase();$.ajax({url:"php/get_values.php",type:"GET",dataType:"json",success:function(a){if(a.success){const c=a.product,r=o.cardTitleText.includes("Daily Income Free")&&null!==n;c.includes("Daily Income Free")&&r&&(e.disabled=!0,t.textContent="Already Purchased Free Product! Please wait until the product's expiration before making another purchase.")}else t.textContent="Error occurred while fetching data from the server."},error:function(){t.textContent="Network response was not OK 1 in php/get_values.php",new bootstrap.Modal(document.getElementById("purchaseModal")).show()}}),e.disabled=!1,t.innerHTML=`Income: Daily Basis<br>Invest Money: ₹${o.investMoney}<br>Income Daily: ₹${o.incomeDaily}<br>Income Days: ${o.incomeDays}<br>Gift: VIP Level ${o.gift}`,new bootstrap.Modal(document.getElementById("purchaseModal")).show()}
function welfare(){const confirmButton=document.getElementById("confirm"),investMoneyTextElement=document.getElementById("investMoneyText");var welfareButton=document.querySelector(".card-body button");confirmButton.disabled=!1,welfareButton.disabled=!0;const purchaseInfo=purchase();investMoneyTextElement.innerHTML=`Income: VIP Based Income<br>Invest Money: ₹${purchaseInfo.investMoney}<br>Income Daily: ₹${purchaseInfo.incomeDaily}<br>Income Days: ${purchaseInfo.incomeDays}<br>Requirement: VIP Level ${purchaseInfo.reqgift}`,$.ajax({url:"php/get_values.php",type:"GET",dataType:"json",success:function(data){if(data.success){const gift=data.gift;gift.includes(purchaseInfo.reqgift)||(confirmButton.disabled=!0,investMoneyTextElement.textContent=`Purchase Daily Income Product of level: ${purchaseInfo.reqgift}`)}},error:function(){investMoneyTextElement.textContent="Network response was not OK 2 in php/get_values.php";const purchaseModal=new bootstrap.Modal(document.getElementById("purchaseModal"));purchaseModal.show()}});const purchaseModal=new bootstrap.Modal(document.getElementById("purchaseModal"));purchaseModal.show()}
// If u Don't want to limit the purchase of welfare product, then Find the below ajax in welfare() function and Replace it with below code
// Using this below in welfare() will limit the purchase of welfare to 1 (u can only purchase welfare once)
// ,$.ajax({url:"php/get_values.php",type:"GET",dataType:"json",success:function(data){if(data.success){const gift=data.gift,invest_money=data.invest_money.map(Number),cleanedInvestMoney=parseFloat(purchaseInfo.investMoney.replace(/,/g,""));invest_money.includes(cleanedInvestMoney)?(confirmButton.disabled=!0,investMoneyTextElement.innerHTML="Already Purchased VIP "+purchaseInfo.reqgift+" Product! Please wait until the product's expiration before making another purchase."):gift.includes(purchaseInfo.reqgift)?(welfareButton.disabled=!1,confirmButton.disabled=!1):(confirmButton.disabled=!0,investMoneyTextElement.textContent=`Purchase Daily Income Product of level: ${purchaseInfo.reqgift}`)}},error:function(){investMoneyTextElement.textContent="Network response was not OK 2 in php/get_values.php";const purchaseModal=new bootstrap.Modal(document.getElementById("purchaseModal"));purchaseModal.show()}});

function confirmPurchase() {
const text=investMoneyTextElement.textContent,investMoneyPattern=/Invest Money: ₹(\d+(,\d+)*)/,investMoneyMatch=text.match(investMoneyPattern),investMoneyString=investMoneyMatch?investMoneyMatch[1]:"",investMoney=parseFloat(investMoneyString.replace(/,/g,""));let product,incomeDaily,incomeDays,gift=0;
  //define all products here
  switch (investMoney) {
    case 0:
      product = "Daily Income Free";
      incomeDaily = 10;
      incomeDays = 60;
      gift = 0;
      break;
    case 477:
      product = "Daily Income 1";
      incomeDaily = 110;
      incomeDays = 60;
      gift = 1;
      break;
    case 1800:
      product = "Daily Income 2";
      incomeDaily = 646;
      incomeDays = 60;
      gift = 2;
      break;
    case 3700:
      product = "Daily Income 3";
      incomeDaily = 1461;
      incomeDays = 60;
      gift = 3;
      break;
    case 8000:
      product = "Daily Income 4";
      incomeDaily = 3800;
      incomeDays = 60;
      gift = 4;
      break;
    case 16000:
      product = "Daily Income 5";
      incomeDaily = 7000;
      incomeDays = 60;
      gift = 5;
      break;
    case 30000:
      product = "Daily Income 6";
      incomeDaily = 14500;
      incomeDays = 60;
      gift = 6;
      break;
    case 42000:
      product = "Daily Income 7";
      incomeDaily = 20160;
      incomeDays = 60;
      gift = 7;
      break;
    case 80000:
      product = "Daily Income 8";
      incomeDaily = 41600;
      incomeDays = 60;
      gift = 8;
      break;


    case 1000:
      product = "Welfare Income 1";
      incomeDaily = 700;
      incomeDays = 3;
      break;
    case 3500:
      product = "Welfare Income 2";
      incomeDaily = 2100;
      incomeDays = 3;
      break;
    case 6000:
      product = "Welfare Income 3";
      incomeDaily = 3500;
      incomeDays = 3;
      break;
    case 15000:
      product = "Welfare Income 4";
      incomeDaily = 8000;
      incomeDays = 3;
      break;
    case 20000:
      product = "Welfare Income 5";
      incomeDaily = 13500;
      incomeDays = 3;
      break;
    case 29999:
      product = "Welfare Income 6";
      incomeDaily = 30000;
      incomeDays = 3;
      break;
    case 41999:
      product = "Welfare Income 7";
      incomeDaily = 50000;
      incomeDays = 3;
      break;
    case 79999:
      product = "Welfare Income 8";
      incomeDaily = 100000;
      incomeDays = 3;
      break;

    default:
      throw new Error(`[NOT MENTIONED PRODUCT IN SWITCH STATEMENT]`);
  }

const total_income = incomeDaily * incomeDays;
$.ajax({url:"php/get_values.php",type:"GET",dataType:"json",success:function(data){if(data.success){const recharge=parseFloat(data.recharge,10);if(recharge<investMoney)confirmButton.disabled=!0,investMoneyTextElement.innerHTML=`Insufficient Recharge!<br>Recharge Amount: ₹${recharge.toLocaleString()}`;else try{0!==gift&&invite(investMoney);const newRecharge=recharge-investMoney;investMoneyTextElement.innerHTML="Purchase Successful!",confirmButton.disabled=!0;const purchaseData={recharge:newRecharge,product:product,investMoney:investMoney,incomeDaily:incomeDaily,incomeDays:incomeDays,total_income:total_income,gift:gift};$.ajax({url:"php/post_values.php",type:"POST",dataType:"json",contentType:"application/json",data:JSON.stringify(purchaseData),success:function(data){data.success?(console.log(data.message),console.log("Reward is "+data.reward+" for Previous user's Bonus Btn! "),console.log("Purchase is "+data.purchase+" for Current user! ")):console.error("Error:",data.message)},error:function(){console.log("Network response was not OK 3 in php/post_values.php.")}})}catch(error){console.log(error)}}else console.error("Error:",data.message)},error:function(){console.log("Network response was not OK 4 in php/get_values.php.")}});

}

function invite(investMoney){$.ajax({url:"php/get_values.php",type:"GET",dataType:"json",success:function(data){if(data.success){const presentUserMobile=data.presentUserMobile,level1Mobile=data.level1Mobile,level2Mobile=data.level2Mobile,level3Mobile=data.level3Mobile,balance1=parseFloat(data.balance1,10),balance2=parseFloat(data.balance2,10),balance3=parseFloat(data.balance3,10),byinvite1=parseFloat(data.byinvite1,10),byinvite2=parseFloat(data.byinvite2,10),byinvite3=parseFloat(data.byinvite3,10);var newBalance1,newBalance2,newBalance3,newbyinvite1,newbyinvite2,newbyinvite3;null!==level1Mobile?(newBalance1=balance1+.17*investMoney,newbyinvite1=byinvite1+.17*investMoney):(newBalance1=balance1,newbyinvite1=byinvite1),null!==level2Mobile?(newBalance2=balance2+.02*investMoney,newbyinvite2=byinvite2+.02*investMoney):(newBalance2=balance2,newbyinvite2=byinvite2),null!==level3Mobile?(newBalance3=balance3+.01*investMoney,newbyinvite3=byinvite3+.01*investMoney):(newBalance3=balance3,newbyinvite3=byinvite3),$.ajax({url:"php/post_values.php",type:"POST",dataType:"json",contentType:"application/json",data:JSON.stringify({presentUserMobile:presentUserMobile,investMoney:investMoney,level1Mobile:level1Mobile,level2Mobile:level2Mobile,level3Mobile:level3Mobile,balance1:newBalance1,balance2:newBalance2,balance3:newBalance3,byinvite1:newbyinvite1,byinvite2:newbyinvite2,byinvite3:newbyinvite3}),success:function(data){console.log(data.message)},error:function(){console.log("Network response was not OK 5 in php/post_values.php")}})}},error:function(){console.log("Network response was not OK 6 in php/get_values.php")}})}
