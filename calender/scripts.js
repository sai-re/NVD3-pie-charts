(function ($) {
    (function monthCalender() {
        //declaring variables for displaying months
        var Nowmoment = moment(),
            list = '<ul class="calenderApp__calender__allMonths">',
            i = 0,
            months = [],
            mouseClick = 0;
        //loop to create months
        for (i; i < 12; i++) {
            months.push(Nowmoment.month(i).format("MMM"));
            list += "<li class='calenderApp__calender__allMonths__month'>" + months[i] + "</li>";
        } //end loop
        //display months
        list += '</ul>';
        $(".calenderApp__calender").html(list);
        //declaring variables
        var startMonth,
            endMonth,
            month = $(".calenderApp__calender__allMonths__month"),
            messageBox = $(".calenderApp__message"),
            successMsg = $(".calenderApp__success"),
            updateButton = $(".calenderApp__filterButton"),
            clearButton = $(".calenderApp__clearButton"),
            options = $('.calenderApp__dropdown__years');
        //display error msg
        function errorMsg() {
            messageBox.html("Please choose a valid date range").css({
                "margin-bottom": "10px"
            });
        };
        //reset background colors to white
        function resetColors() {
            $(month).css({
                "background-color": "#fff",
                "color": "#333",
                "border-radius": "0",
                "border-radius": "0"
            });
        }
        //reset values to default
        function resetValues () {
            startMonth = undefined;
            endMonth = undefined;
            year = options.val("0");
        }
        //MONTH BUTTON    
        $(month).on('click', function () {
            mouseClick++;
            //condition for 1st click
            if (mouseClick === 1) {
                //remove any previous msg
                messageBox.html("").css({
                    "margin-bottom": "0px"
                });
                successMsg.html("").css({
                    "margin-bottom": "0px"
                });
                //highlight selected month
                $(this).css({
                    "background-color": "#5cb85c",
                    'color': "#e7e7e7",
                    "border-bottom-left-radius": "10px",
                    "border-top-left-radius": "10px"
                });
                //assign index of selected month into variable
                startMonth = $(this).index() + 1;
            }
            //condition for 2nd click
            else if (mouseClick === 2) {
                //highlight selected month
                $(this).css({
                    "background-color": "#5cb85c",
                    'color': "#e7e7e7",
                    "border-bottom-right-radius": "10px",
                    "border-top-right-radius": "10px"
                });
                //assign index of selected month into variable
                endMonth = $(this).index() + 1;
                //highlight the months between the start and end
                month.slice(startMonth, endMonth - 1).css("background-color", "#BAE8BA");
                //error if incorrect range is selected
                if (startMonth > endMonth) {
                    errorMsg();
                }
            }
            //3rd click resets back to default
            else {
                resetColors();
                mouseClick = 0;
                messageBox.html("").css({
                    "margin-bottom": "0px"
                });
            }
        }); //end click
        //UPDATE BUTTON conditioms to test each scenario 
        updateButton.on("click", function () {
            //selected year in dropdown is assigned to variable
            var year = options.val();
            //reset colors back to default
            resetColors();
            if (year !== "0" && startMonth === undefined && endMonth === undefined) {
                //condition for year only 
                messageBox.html("Year " + year).css({
                    "margin-bottom": "10px"
                });
            }
            else if (year === "0" && startMonth === undefined && endMonth === undefined) {
                //condition for all data 
                messageBox.html("All data").css({
                    "margin-bottom": "10px"
                });
            }
            else {
                if (year == "0") {
                    //condition for months only
                    messageBox.html("From " + months[startMonth - 1] + " - " + months[endMonth - 1]).css({
                        "margin-bottom": "10px"
                    });
                }
                else {
                    //condition for months and years    
                    messageBox.html("From " + months[startMonth - 1] + " - " + months[endMonth - 1] + " " + year).css({
                        "margin-bottom": "10px"
                    });
                }
            }
            //function to send data to php
            function sendAjax (chartUrl) {    
                //Dont send ajax if error
                if (startMonth > endMonth) {
                    errorMsg();
                }
                else {
                    //begin Ajax
                    var url = chartUrl;
                    //data to send
                    var dateInfo = {
                        start: startMonth,
                        end: endMonth,
                        years: year
                    };
                    //callback function
                    function successful(data) {
                        console.log("success");
                        //call updated charts on success
                        callD3Charts();
                        //success message only if request is sent
                        successMsg.html("Updated, choose another option").css({
                            "margin-bottom": "10px"
                        });
                    }
                    //send request
                    $.ajax({
                        type: 'POST',
                        url: url,
                        data: dateInfo,
                        success: successful
                    });
                }
            }
            sendAjax("data/sessions.php");            
            //reset mouse counter
            mouseClick = 0;
            //reset all values once sent
            resetValues();
        }); //end click 
        //CLEAR BUTTON
        clearButton.on("click", function () {
            //reset all values
            resetValues();
            //set mouse to default
            mouseClick = 0;
            //reset background colours
            resetColors();
            //clear messages
            messageBox.html("").css({
                "margin-bottom": "0px"
            });
            successMsg.html("").css({
                "margin-bottom": "0px"
            });
        }); //end click
    }()); //end function
})(jQuery); //end Jquery