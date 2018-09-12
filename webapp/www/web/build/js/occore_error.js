webpackJsonp([3],{

/***/ "./src/OC/CoreBundle/Resources/public/js/error.js":
/*!********************************************************!*\
  !*** ./src/OC/CoreBundle/Resources/public/js/error.js ***!
  \********************************************************/
/*! dynamic exports provided */
/*! all exports used */
/***/ (function(module, exports) {

function randomNum() {
	"use strict";

	return Math.floor(Math.random() * 9) + 1;
}
var loop1,
    loop2,
    loop3,
    time = 30,
    i = 0,
    number,
    selector3 = document.querySelector('.thirdDigit'),
    selector2 = document.querySelector('.secondDigit'),
    selector1 = document.querySelector('.firstDigit');
loop3 = setInterval(function () {
	"use strict";

	if (i > 40) {
		clearInterval(loop3);
		selector3.textContent = 4;
	} else {
		selector3.textContent = randomNum();
		i++;
	}
}, time);
loop2 = setInterval(function () {
	"use strict";

	if (i > 80) {
		clearInterval(loop2);
		selector2.textContent = 0;
	} else {
		selector2.textContent = randomNum();
		i++;
	}
}, time);
loop1 = setInterval(function () {
	"use strict";

	if (i > 100) {
		clearInterval(loop1);
		selector1.textContent = 4;
	} else {
		selector1.textContent = randomNum();
		i++;
	}
}, time);

/***/ })

},["./src/OC/CoreBundle/Resources/public/js/error.js"]);
//# sourceMappingURL=data:application/json;charset=utf-8;base64,eyJ2ZXJzaW9uIjozLCJzb3VyY2VzIjpbIndlYnBhY2s6Ly8vLi9zcmMvT0MvQ29yZUJ1bmRsZS9SZXNvdXJjZXMvcHVibGljL2pzL2Vycm9yLmpzIl0sIm5hbWVzIjpbInJhbmRvbU51bSIsIk1hdGgiLCJmbG9vciIsInJhbmRvbSIsImxvb3AxIiwibG9vcDIiLCJsb29wMyIsInRpbWUiLCJpIiwibnVtYmVyIiwic2VsZWN0b3IzIiwiZG9jdW1lbnQiLCJxdWVyeVNlbGVjdG9yIiwic2VsZWN0b3IyIiwic2VsZWN0b3IxIiwic2V0SW50ZXJ2YWwiLCJjbGVhckludGVydmFsIiwidGV4dENvbnRlbnQiXSwibWFwcGluZ3MiOiI7Ozs7Ozs7Ozs7QUFBQSxTQUFTQSxTQUFULEdBQ0E7QUFDQzs7QUFDQSxRQUFPQyxLQUFLQyxLQUFMLENBQVdELEtBQUtFLE1BQUwsS0FBZ0IsQ0FBM0IsSUFBOEIsQ0FBckM7QUFDQTtBQUNELElBQUlDLEtBQUo7QUFBQSxJQUFVQyxLQUFWO0FBQUEsSUFBZ0JDLEtBQWhCO0FBQUEsSUFBc0JDLE9BQUssRUFBM0I7QUFBQSxJQUErQkMsSUFBRSxDQUFqQztBQUFBLElBQW9DQyxNQUFwQztBQUFBLElBQTRDQyxZQUFZQyxTQUFTQyxhQUFULENBQXVCLGFBQXZCLENBQXhEO0FBQUEsSUFBK0ZDLFlBQVlGLFNBQVNDLGFBQVQsQ0FBdUIsY0FBdkIsQ0FBM0c7QUFBQSxJQUNDRSxZQUFZSCxTQUFTQyxhQUFULENBQXVCLGFBQXZCLENBRGI7QUFFQU4sUUFBUVMsWUFBWSxZQUNwQjtBQUNFOztBQUNELEtBQUdQLElBQUksRUFBUCxFQUNBO0FBQ0NRLGdCQUFjVixLQUFkO0FBQ0FJLFlBQVVPLFdBQVYsR0FBd0IsQ0FBeEI7QUFDQSxFQUpELE1BS0E7QUFDQ1AsWUFBVU8sV0FBVixHQUF3QmpCLFdBQXhCO0FBQ0FRO0FBQ0E7QUFDRCxDQVpPLEVBWUxELElBWkssQ0FBUjtBQWFBRixRQUFRVSxZQUFZLFlBQ3BCO0FBQ0U7O0FBQ0QsS0FBR1AsSUFBSSxFQUFQLEVBQ0E7QUFDQ1EsZ0JBQWNYLEtBQWQ7QUFDQVEsWUFBVUksV0FBVixHQUF3QixDQUF4QjtBQUNBLEVBSkQsTUFLQTtBQUNDSixZQUFVSSxXQUFWLEdBQXdCakIsV0FBeEI7QUFDQVE7QUFDQTtBQUNELENBWk8sRUFZTEQsSUFaSyxDQUFSO0FBYUFILFFBQVFXLFlBQVksWUFDcEI7QUFDRTs7QUFDRCxLQUFHUCxJQUFJLEdBQVAsRUFDQTtBQUNDUSxnQkFBY1osS0FBZDtBQUNBVSxZQUFVRyxXQUFWLEdBQXdCLENBQXhCO0FBQ0EsRUFKRCxNQUtBO0FBQ0NILFlBQVVHLFdBQVYsR0FBd0JqQixXQUF4QjtBQUNBUTtBQUNBO0FBQ0QsQ0FaTyxFQVlMRCxJQVpLLENBQVIsQyIsImZpbGUiOiJqcy9vY2NvcmVfZXJyb3IuanMiLCJzb3VyY2VzQ29udGVudCI6WyJmdW5jdGlvbiByYW5kb21OdW0oKVxue1xuXHRcInVzZSBzdHJpY3RcIjtcblx0cmV0dXJuIE1hdGguZmxvb3IoTWF0aC5yYW5kb20oKSAqIDkpKzE7XG59XG52YXIgbG9vcDEsbG9vcDIsbG9vcDMsdGltZT0zMCwgaT0wLCBudW1iZXIsIHNlbGVjdG9yMyA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy50aGlyZERpZ2l0JyksIHNlbGVjdG9yMiA9IGRvY3VtZW50LnF1ZXJ5U2VsZWN0b3IoJy5zZWNvbmREaWdpdCcpLFxuXHRzZWxlY3RvcjEgPSBkb2N1bWVudC5xdWVyeVNlbGVjdG9yKCcuZmlyc3REaWdpdCcpO1xubG9vcDMgPSBzZXRJbnRlcnZhbChmdW5jdGlvbigpXG57XG4gIFwidXNlIHN0cmljdFwiO1xuXHRpZihpID4gNDApXG5cdHtcblx0XHRjbGVhckludGVydmFsKGxvb3AzKTtcblx0XHRzZWxlY3RvcjMudGV4dENvbnRlbnQgPSA0O1xuXHR9ZWxzZVxuXHR7XG5cdFx0c2VsZWN0b3IzLnRleHRDb250ZW50ID0gcmFuZG9tTnVtKCk7XG5cdFx0aSsrO1xuXHR9XG59LCB0aW1lKTtcbmxvb3AyID0gc2V0SW50ZXJ2YWwoZnVuY3Rpb24oKVxue1xuICBcInVzZSBzdHJpY3RcIjtcblx0aWYoaSA+IDgwKVxuXHR7XG5cdFx0Y2xlYXJJbnRlcnZhbChsb29wMik7XG5cdFx0c2VsZWN0b3IyLnRleHRDb250ZW50ID0gMDtcblx0fWVsc2Vcblx0e1xuXHRcdHNlbGVjdG9yMi50ZXh0Q29udGVudCA9IHJhbmRvbU51bSgpO1xuXHRcdGkrKztcblx0fVxufSwgdGltZSk7XG5sb29wMSA9IHNldEludGVydmFsKGZ1bmN0aW9uKClcbntcbiAgXCJ1c2Ugc3RyaWN0XCI7XG5cdGlmKGkgPiAxMDApXG5cdHtcblx0XHRjbGVhckludGVydmFsKGxvb3AxKTtcblx0XHRzZWxlY3RvcjEudGV4dENvbnRlbnQgPSA0O1xuXHR9ZWxzZVxuXHR7XG5cdFx0c2VsZWN0b3IxLnRleHRDb250ZW50ID0gcmFuZG9tTnVtKCk7XG5cdFx0aSsrO1xuXHR9XG59LCB0aW1lKTtcblxuXG4vLyBXRUJQQUNLIEZPT1RFUiAvL1xuLy8gLi9zcmMvT0MvQ29yZUJ1bmRsZS9SZXNvdXJjZXMvcHVibGljL2pzL2Vycm9yLmpzIl0sInNvdXJjZVJvb3QiOiIifQ==