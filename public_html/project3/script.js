// Mean Function
function calcMean(array) {

	// Return the Sum by the array length. 
	return (calcSum(array) / array.length).toFixed(2);
}


// Median Function
function calcMedian(array) {
	
	// Instatiate Variables for Test function 
	var CreateTestFunction = function(foo1,foo2){
		return foo1-foo2;
	}
	// Sort the list
	var sortedNumMedian = array.sort(CreateTestFunction);
	
	// Get the half 
	var half = Math.floor(sortedNumMedian.length / 2);
	var returnMedian = ((sortedNumMedian[half-1] + sortedNumMedian[half]) / 2.0);
	
	// Check to see if the Sorted lists divides evenly
	if (sortedNumMedian.length %2) {
		return sortedNumMedian[half].toFixed(2);
	} else{
	
	  // Return median
	return returnMedian.toFixed(2);
	}
}

// Mode Function
function calcMode(array) {
	
	// Instantiate Variales
	var modes = [],countNums = [], numberMode, maxIndexMode = 0;
	var i=0;
	
	// Iterate though list
	while (i<array.length) {
		numberMode = array[i];
		countNums[numberMode] = (countNums[numberMode] || 0) + 1;
        if (countNums[numberMode] > maxIndexMode) {
            maxIndexMode = countNums[numberMode];
        }
		i++;
    }
	// Count the modes
    for (i in countNums)
        if (countNums.hasOwnProperty(i)) {
            if (countNums[i] === maxIndexMode) {
                modes.push(Number(i));
            }
    }
	
	// Reutrn Mode
    modes = modes.join(" ");
    return modes;
}

// Calculate Standard Deviation
function calcStd(array) {

	// Return the square root of the variance. 
	return Math.sqrt(calcVariance(array)).toFixed(2);
}

// Calculate Sum
function calcSum(array) {

	// Instantiate variables
	var sumNums = 0;
	var i=0
	
	// Iterate through the list 
	while(i<array.length) 
	{
		// Sum of the values
		sumNums = sumNums + Number(array[i]);	
		i++;
	}
	// Return the sum 
	return sumNums.toFixed(2);
}


// Calculate the Variance
function calcVariance(array) 
{ 
   // Instantitate variables
   var mean = calcMean(array);
   var sum = 0;
   
   // Calcualte Variance
   array.map((VarianceMap)=>sum = sum + Math.pow((mean - VarianceMap),2));
   
   // Return Variance 
   return  (sum / array.length).toFixed(2); 
}

// Caluclate Max
function findMax(array) {

	var max = 0;
	var i = 0;
	
	// Iterate through the list to find the Max
	while(i<array.length) {
		
		// Check to see if the list had a maximum value. 
		if (array[i] > max) {
			max = array[i];
		}
		i++;
	}
	
	// Return Max 
	return max.toFixed(2);
}

// Caluclate Min 
function findMin(array) {

	// Instantiate variables 
	var min = array[0];
	var i=0;
	
	// Iterate through the list to find the Min
	while( i<array.length) {
		
		// Check to see if the list had a minimum value. 
		if (array[i] < min) 
			array[i] = min;	
		i++;
	}
	
	// Return Min
	return min.toFixed(2);
}

// Now to Preform the  math 
function performStatistics() {	
	
	// Instantiate variables
	var Stats = document.getElementById("stats").value.replace(/\s+/g, ' ').trim().split(" ");
	var RangeLimit = Stats.length > 4 && Stats.length < 21;
	var i=0;
	
	// Iterate through the list 
	while (i< Stats.length) {
		
		// Check to see if the numbers are numbers 
		var NotANum = !isNaN(Stats[i]);
		
		// Check to see if the lists are numbers and fits within the range
		if ((NotANum) && (RangeLimit)) {
			Stats[i] = Number(Stats[i]);
			// Check to see if the list of numbers have values between 1 - 100. 
			if (Stats[i] < 0 || Stats[i] > 100){ 
				alert('Invalid input! Numbers must be between 0 and 100.')
			    return false
			}
		}
		// Else to see if the list of numbers are numbers and don't enter special characters. 
		else {
			alert("Error: User must enter a number between 1 - 20 separated by spaces with only numeric values!");
			return false;
		}
		 i++;
	}
	
	// Return the read input to the html form 
	document.getElementById("max").value = findMax(Stats);
 	document.getElementById("mean").value = calcMean(Stats);
	document.getElementById("median").value = calcMedian(Stats);
	document.getElementById("min").value = findMin(Stats);
	document.getElementById("std").value = calcStd(Stats);
	document.getElementById("sum").value = calcSum(Stats);
	document.getElementById("variance").value = calcVariance(Stats);
	document.getElementById("mode").value = calcMode(Stats);
	
	return false;
	
}

