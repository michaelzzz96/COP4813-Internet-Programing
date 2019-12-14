// Variaibles used for the credit card
var creditForm = 
'<br> First Name:<input type=text  id=firstname name=firstname required><br>' +

'Last Name:<input type=text id=lastname name=lastname required><br>' +

'Address:<input type=text id=address name=address required><br>' +

"City:<input type=text id=city name=city  required><br>" +

'Zip:<input type=text  id=zip name=zip required><br>' +


'Email Address:<input type=text id=email name=email required><br>' +

'Name on Card:<input type=text  id=namecard name=namecard required><br>' +

'Card Number:<input type=text  id=creditcardnumber name=creditcardnumber required><br>' +

'<a href="https://en.wikipedia.org/wiki/Card_security_code" target="blank">CVV2/CVC:</a>' +
 '<input type="text" name="cvc" id="cvc" required /><br>' +
 


'State: <select id=state name=state  required> ' + 
'<option selected=selected value=SelectGivenState>Select State</option>' + 

'<option value=AL>Alabama</option> <option value=AK>Alaska</option>' + 

'<option value=AZ>Arizona</option> <option value=AR>Arkansas</option>' +  

'<option value=CA>California</option>' + 

'<option value=CO>Colorado</option>' + 

'<option value=CT>Connecticut</option>' +

'<option value=DE>Delaware</option>' +  

'<option value=DC>District Of Columbia</option>' + 

'<option value=FL>Florida</option>' + 

'<option value=GA>Georgia</option>' + 

'<option value=HI>Hawaii</option>' + 

'<option value=ID>Idaho</option>' +

'<option value=IL>Illinois</option>' +

'<option value=IN>Indiana</option>' + 

'<option value=IA>Iowa</option>' + 

'<option value=KS>Kansas</option>' + 

'<option value=KY>Kentucky</option>' +

'<option value=LA>Louisiana</option>' + 

'<option value=ME>Maine</option>' + 

'<option value=MD>Maryland</option>' + 

'<option value=MA>Massachusetts</option>' + 

'<option value=MI>Michigan</option>' + 

'<option value=MN>Minnesota</option>' + 

'<option value=MS>Mississippi</option>' + 

'<option value=MO>Missouri</option>' + 

'<option value=MT>Montana</option>' + 

'<option value=NE>Nebraska</option>' + 

'<option value=NV>Nevada</option>' +

'<option value=NH>New Hampshire</option>' + 

'<option value=NJ>New Jersey</option>' + 

'<option value=NM>New Mexico</option>' + 

'<option value=NY>New York</option>'+ 

'<option value=NC>North Carolina</option>' +

'<option value=ND>North Dakota</option>' + 

'<option value=OH>Ohio</option>'+ 

'<option value=OK>Oklahoma</option>' + 

'<option value=OR>Oregon</option>'+ 

'<option value=PA>Pennsylvania</option>' + 

'<option value=RI>Rhode Island</option>' + 

'<option value=SC>South Carolina</option>' + 

'<option value=SD>South Dakota</option>' + 

'<option value=TN>Tennessee</option>' + 

'<option value=TX>Texas</option>' + 

'<option value=UT>Utah</option>' + 

'<option value=VT>Vermont</option>' + 

'<option value=VA>Virginia</option>' + 

'<option value=WA>Washington</option>' +

'<option value=WV>West Virginia</option>' + 

'<option value=WI>Wisconsin</option>' + 

'<option value=WY>Wyoming</option>' + 

'</select><br>' +


'Expiry:<input type=month value="2019-04" min="2017-01" max="2020-12" name=Expiry id=Expiry required></form><br><br>';

// Variables used for paypal 
var PaypalForm =

'<br> Email Address:<input type=email id=paypalemail  name=paypalemail  required> <br>' +

'Password:<input type=password id=password name=password required> <br><br>';

// Alternate Forms 
document.getElementBy("CreditCardInfo").checked = true;
document.getElementById("PaypalInfo").checked = false;
    
   function testLength(value, length, exactLength){


        if(exactLength){
			// true
           return value.length == length;
		} else {
			// false
		  return value.length >= length;
		}
		
    } 
	
	
	function testNumber(value){
		if(isNaN(value)){
			return false;
		}
		else{
			return true;
		}
	}



function validateForm(){
	
    if(document.getElementById("CreditCardInfo").checked){
		
		// Matching Table
		var CvCChecker = validateControl(document.getElementById("cvc").value, 3);
		var CardChecker =  validateCreditCard(document.getElementById("creditcardnumber").value, 5);	
		var ZipChecker = validateControl(document.getElementById("zip").value);
		var ExpirationChecker = validateDate(document.getElementById("Expiry").value);
		var MailChecker = validateEmail(document.getElementById("email").value);
		var CheckCvC = CvCChecker;
		// Call State Function
		var CheckState = validateState();
        var CheckCard = CardChecker;
		var CheckZipcode = ZipChecker;
		var CheckExperiationDate = ExpirationChecker;
        var CheckEmail = MailChecker;
		
		var TestCreditCard = CheckState  && CheckZipcode && CheckCard  && CheckEmail  && CheckExperiationDate;

		
    if(TestCreditCard == true){
        alert('Tranaction went through');
    }
	
    } else if(document.getElementById("PaypalInfo").checked){
		
		var PaypaymailChecks = validateEmail(document.getElementById("paypalemail").value);
		var PayPalPasswordConfirm =  validatePassword(document.getElementById("password").value);
		
       var CheckPayPalEmail = PaypaymailChecks;
       var CheckPaypalPassword = PayPalPasswordConfirm;
	   
	   var TestingFunctionPaypal = CheckPayPalEmail  && CheckPaypalPassword;
        
		if(TestingFunctionPaypal == true){
            alert('Tranaction went through');
        }
    }
}

// Switch between accounts
function updateForms(){

// Default Credit Card Page 
var CreditOnly = 	
	
document.getElementById("paymentinfo").innerHTML = creditForm;
}



function validateControl(control,name,length){
        
		// Call TestLength function
		let TestLength =  testLength(control, length, true);
		let NonNumeric = testNumber(control);
		
		if(TestLength == false){
            alert('Users value is not the correct length');
            return false;
        }
		
        if(testNumber(control) != true)
        {
        alert('The value the user entered is not a number. Try again');
        return false;
        }
		
        if(TestLength == true && NonNumeric == true){
            return true;
        }

        return true;
    }


 
function validateCreditCard(value) {
	
	//Remove any spaces
	TestCardValue = value.replace(/\s/g, "");
	
	//If user doesen't enter digits
	TestCardNumber = testNumber(TestCardValue);
	
	if (TestCardNumber == false) {
		alert('The card user entered needs to be in digits.');
		return false;
	}
	
	// Mathching Each Card From the table
	let DiscoverFirst = TestCardValue.charAt(0) === "6";
	let MasterFirst = TestCardValue.charAt(0) === "5";
	let VisaFirst = TestCardValue.charAt(0) === "4";
	let AmericanFirst = TestCardValue.charAt(0) === "3";
	let AmericanTestExpress = testLength(TestCardValue, 15, true);
	let AnyOtherCard = testLength(TestCardValue, 16, true);
	
	
	// Testing American Express card
	if (AmericanFirst) {
		if ( AmericanTestExpress )	
			return true;
		else  {
			alert('The American Express card you entered is not valid');	
			return false
		}
	}

	// Testing  Discover card
	else if (DiscoverFirst) {
		if ( AnyOtherCard )	
			return true;
		else {
			alert('The Discover card you entered is not valid');	
			return false;
		}
	}

	// Testing Master card
	else if (MasterFirst) {
		if ( AnyOtherCard )	
			return true;
		else {
			alert('The MasterCard you entered is not valid');	
			return false;
		}
	}

	// Testing Visa card
	else if (VisaFirst) {
		if ( AnyOtherCard )
			return true;
		else {
			alert("The Visa card you entered is not valid");	
			return false;
		}
	}

	// If no cards works
	alert("The card you enterd is not valid");
	return false;
}



function validateEmail(email) {

	// Regular Expression
	var regularExpression =/^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;

	if (regularExpression.test(email)){
		return true;
	}
	
	else {
		alert('Email address is not valid.');
		return false;
	}
}


function validateState() {
  var state = document.getElementById('state');
  if (state.selectedIndex == 0) {  
    alert('User must select a state');
    return false;
  }
  return true;
}

 
     function validateDate(value){
     var date = document.getElementById("Expiry").value;
	 // Date Object
     var NewDate = new Date();
	 var ExperiationDate = new Date(date);
     if (ExperiationDate > NewDate){
         return true;

     }
     else{
		 alert("The Date you entered has Expired");
     }
    }


 function validatePassword(value, minLength){
   
     // My minimum password length
	 var minimumpassword = 7;	 
	 var TestLength = testLength(value, minimumpassword, false);
   
     if(TestLength === true){
         return TestLength;
     }
     else{
         alert('The password you enteted is not valid. Must be 7 characters or greater.');
     }
     }
	 

	
function updateForm(control){
	

	
	var div = document.getElementById("paymentinfo");
	
	if (control.id == "CreditCardInfo"){
	div.innerHTML = creditForm;
    
}
    else if (control.id == "PaypalInfo"){
      div.innerHTML = PaypalForm; 
    }
}

