<!doctype html>

<!-- Satellite Image Search Task

Author: Cary Stothart (cary.stothart@gmail.com)
Version: 1.0

################################# DESCRIPTION #################################

This was made to be plugged into a larger experiment.  It will run by itself, 
but the data it collects will go nowhere.

################################### CITATION ##################################

How to cite this software in APA:

Stothart, C. (2016). Satellite Image Search Task (Version 1) [software]. Retrieved from 
http://cary-stothart.net/files/satellite-image-search-task.php.  
     
################################## COPYRIGHT ##################################

The MIT License (MIT)

Copyright (c) 2016 Cary Robert Stothart

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.     

-->

<html>
<head>
    <meta charset=\"utf-8\">
    <title>Satellite Image Search Task</title>
    <style>
    html, body {
      height: 95%;
    }      
    .parent {
      width: 90%;
      margin: 0 auto;
      height: 100%;
      display: table;
      text-align: center;
    }
    .parent > .child {
      display: table-cell;
      vertical-align: middle;
    }
    #content {
      margin: auto;
    }
    .button {
      border: 2px solid #4CAF50;
      color: #000000;
      font-size: 12px;
      width: 150px;
      padding: 10px;
      margin: 0 auto;
    }
    .button:hover {
      background-color: #4CAF50;
      color: #FFFFFF;
      transition-duration: 0.4s;
      cursor: pointer;
    }  
    </style>
</head>
<body>
<div id="page_container">
      
<?php

function search_task() {
    $characters = '0123456789';
    $instance = '';
    for ($i = 0; $i < 8; $i++) {
        $instance .= $characters[rand(0, strlen($characters) - 1)];
    }
    ?>
    <?php
    echo '<input type="hidden" name="id_mt_worker_id" value="'. $_REQUEST["workerId"] . '"/>
          <input type="hidden" name="instance" value="' . $instance . '" />';
          
    $stimuli_array = generateTrialList(10); // CHANGE THIS NUMBER TO CHANGE THE NUMBER OF STIMULI PRESENTED
    $stimuli_array = $stimuli_array[0];
    ?>
    <input type="hidden" name="id_comp_res_x" value="" />
    <input type="hidden" name="id_comp_res_y" value="" />
    <input type="hidden" name="id_comp_avail_res_x" value="" />
    <input type="hidden" name="id_comp_avail_res_y" value="" />
    <input type="hidden" name="id_comp_color_depth" value="" />
    <input type="hidden" name="id_comp_pixel_depth" value="" />
    <input type="hidden" name="id_comp_browser_name" value="" />
    <input type="hidden" name="id_comp_browser_version" value="" />
    <input type="hidden" name="id_comp_browser_code_name" value="" />
    <input type="hidden" name="id_comp_os" value="" />
    <input type="hidden" name="id_comp_ip_address" value="" />
    <div class="parent">
      <div class="child">
        <div id="content"></div>
      </div>
    </div>
    <script>
    
    searchTask.prototype.startTask = function() {
        var self = this;
        var trialTimeSeconds = this.maxTrialTime/1000;
        var instructionsReadButton = "<div class=\"button\" onclick=\"task.goToNextTrial()\">Start</div>"
        var instructions = "You will see " + this.stimuliArray.length.toString() + " satellite images.<br /><br />" +
                           "Look for swimming pools in the images and click on every pool you find.<br /><br />" +
                           "When you have found all of the pools, click the \"Search Complete\" button.<br /><br />" +
                           "You will have " + trialTimeSeconds.toString() + " seconds to search each image.<br /><br />" +
                           "There will be up to 4 pools in each image. And, any image may have 0 pools.<br /><br />" +
                           "After searching an image, you will be asked to enter the number of pools you found.<br /><br />" +
                           "Press the button below when you are ready to begin.";
        document.addEventListener("keydown", function(event) {   // Prevent users from submitting pool counts by pressing enter.
            if(event.keyCode == 13) {
                event.preventDefault();
                return false;
            }
        });
        this.content.innerHTML = instructions + "<br /><br />" + instructionsReadButton;
    }
    
    searchTask.prototype.endTask = function() {
        var meanCountDiff = this.countDiffSum / this.trialNumber;
        //document.search_task.count_results.value = this.countResults;
        //document.search_task.click_results.value = this.clickResults;
        //document.search_task.mean_count_difference.value = meanCountDiff;
        this.content.innerHTML = "You have completed the experiment. Thank you!"
        //document.getElementById("search_task_submit").style.visibility = 'visible';
        
    }
    
    searchTask.prototype.handleClick = function(event) {
        var clickTime = new Date().getTime() - this.startTime;
        img = (event.target || event.srcElement);
        var x = event.pageX - img.offsetLeft;
        var y = event.pageY - img.offsetTop;
        var accuracy = 0;
        var targetFound = "NA";
        this.clickCount += 1;
        if(this.currentTrial[2] == 1) {
            var t1Distance = Math.sqrt(Math.pow(Math.abs(x-this.t1X), 2) + Math.pow(Math.abs(y-this.t1Y), 2));
        }
        if(this.currentTrial[2] == 2) {
            var t1Distance = Math.sqrt(Math.pow(Math.abs(x-this.t1X), 2) + Math.pow(Math.abs(y-this.t1Y), 2));
            var t2Distance = Math.sqrt(Math.pow(Math.abs(x-this.t2X), 2) + Math.pow(Math.abs(y-this.t2Y), 2));
        }
        if(this.currentTrial[2] == 3) {
            var t1Distance = Math.sqrt(Math.pow(Math.abs(x-this.t1X), 2) + Math.pow(Math.abs(y-this.t1Y), 2));
            var t2Distance = Math.sqrt(Math.pow(Math.abs(x-this.t2X), 2) + Math.pow(Math.abs(y-this.t2Y), 2));
            var t3Distance = Math.sqrt(Math.pow(Math.abs(x-this.t3X), 2) + Math.pow(Math.abs(y-this.t3Y), 2));
        }
        if(this.currentTrial[2] == 4) {
            var t1Distance = Math.sqrt(Math.pow(Math.abs(x-this.t1X), 2) + Math.pow(Math.abs(y-this.t1Y), 2));
            var t2Distance = Math.sqrt(Math.pow(Math.abs(x-this.t2X), 2) + Math.pow(Math.abs(y-this.t2Y), 2));
            var t3Distance = Math.sqrt(Math.pow(Math.abs(x-this.t3X), 2) + Math.pow(Math.abs(y-this.t3Y), 2));
            var t4Distance = Math.sqrt(Math.pow(Math.abs(x-this.t4X), 2) + Math.pow(Math.abs(y-this.t4Y), 2));
        }
        if(t1Distance <= this.distanceForFind) {
            accuracy = 1;
            targetFound = 1;
        }
        if(t2Distance <= this.distanceForFind) {
            accuracy = 1;
            targetFound = 2;
        } 
        if(t3Distance <= this.distanceForFind) {
            accuracy = 1;
            targetFound = 3;
        }
        if(t4Distance <= this.distanceForFind) {
            accuracy = 1;
            targetFound = 4;
        }
        this.clickResults += this.trialNumber.toString() + "\t" + accuracy.toString() + "\t" + targetFound.toString() + 
                             "\t" + clickTime.toString() + "\t" + x.toString() + "\t" + y.toString() + "\n";
        document.body.style.background = "#FFFFAA";
        setTimeout(function() {
           document.body.style.background = "#FFFFFF";
        }, 250);
    }
    
    searchTask.prototype.handlePoolCount = function() {
        var poolCount = "NA";
        var countOptions = document.getElementsByName("pool_count");
        for(var i = 0, length = countOptions.length; i < length; i++) {
            if (countOptions[i].checked) {
                poolCount = countOptions[i].value;
                break;
            }
        }
        if(poolCount == "NA") {
            alert("Please select a value.");
        }
        else {
            this.countDiffSum += Math.abs(poolCount - this.currentTrial[2]);
            this.countResults += this.trialNumber + "\t" + this.currentTrial[0] + "\t" + this.currentTrial[2] + "\t" + poolCount.toString() + "\t" +
                                 this.searchTime.toString() + "\t" + this.clickCount.toString() + "\t";
            if(this.currentTrial[2] == 0) {
                this.countResults += "NA\tNA\tNA\tNA\tNA\tNA\tNA\tNA\n"
            }
            if(this.currentTrial[2] == 1) {
                this.countResults += this.t1X.toString() + "\t" + this.t1Y.toString() + "\tNA\tNA\tNA\tNA\tNA\tNA\n";
            }
            if(this.currentTrial[2] == 2) {
                this.countResults += this.t1X.toString() + "\t" + this.t1Y.toString() + "\t" + this.t2X.toString() + "\t" + this.t2Y.toString() + 
                                     "\tNA\tNA\tNA\tNA\n";
            }
            if(this.currentTrial[2] == 3) {
                this.countResults += this.t1X.toString() + "\t" + this.t1Y.toString() + "\t" + this.t2X.toString() + "\t" + this.t2Y.toString() + 
                                     "\t" + this.t3X.toString() + "\t" + this.t3Y.toString() + "\tNA\tNA\n";
            }
            if(this.currentTrial[2] == 4) {
                this.countResults += this.t1X.toString() + "\t" + this.t1Y.toString() + "\t" + this.t2X.toString() + "\t" + this.t2Y.toString() + 
                                     "\t" + this.t3X.toString() + "\t" + this.t3Y.toString() + "\t" + this.t4X.toString() + "\t" + this.t4Y.toString() + "\n"
            }               
            this.goToNextTrial();
        }
    }
    
    searchTask.prototype.getTargetCount = function() {
        var self = this;
        clearTimeout(this.trialTimer);
        this.endTime = new Date().getTime();
        this.searchTime = this.endTime - this.startTime;
        this.content.innerHTML = "How many pools did you find?<br /><br />" +
                                 "<input type=\"radio\" id=\"pool_entry\" name=\"pool_count\" value=\"0\"/>0&nbsp;&nbsp;&nbsp;" +
                                 "<input type=\"radio\" id=\"pool_entry\" name=\"pool_count\" value=\"1\"/>1&nbsp;&nbsp;&nbsp;" +
                                 "<input type=\"radio\" id=\"pool_entry\" name=\"pool_count\" value=\"2\"/>2&nbsp;&nbsp;&nbsp;" +
                                 "<input type=\"radio\" id=\"pool_entry\" name=\"pool_count\" value=\"3\"/>3&nbsp;&nbsp;&nbsp;" +
                                 "<input type=\"radio\" id=\"pool_entry\" name=\"pool_count\" value=\"4\"/>4" +
                                 "<br /><br /><div class=\"button\" onclick=\"task.handlePoolCount()\">Continue</div>";
    }
    
    searchTask.prototype.goToNextTrial = function() {
        if(this.stimuliArray.length == 0) {
            this.endTask();
        }
        else {
            this.currentTrial = this.stimuliArray.pop();
            this.trialNumber += 1;
            this.showStimulus();
        }
    }
    
    searchTask.prototype.showStimulus = function() {
        var self = this;
        this.validKeys = [];
        this.content.innerHTML = "Please wait...";
        var image = new Image();
        image.src = "satellite-search-stimuli/" + this.currentTrial[0];
        image.onload = function() {
            self.trialTimer = setTimeout(function() {
                self.getTargetCount();
            }, self.maxTrialTime);
            self.startTime = new Date().getTime();
            self.clickCount = 0;
            if(self.currentTrial[2] == 1) {
                self.t1X = self.currentTrial[3][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t1Y = self.currentTrial[3][1] * (self.stimuliWidth/self.originalStimuliWidth);
            }       
            if(self.currentTrial[2] == 2) {
                self.t1X = self.currentTrial[3][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t1Y = self.currentTrial[3][1] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2X = self.currentTrial[4][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2Y = self.currentTrial[4][1] * (self.stimuliWidth/self.originalStimuliWidth);                
            }          
            if(self.currentTrial[2] == 3) {
                self.t1X = self.currentTrial[3][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t1Y = self.currentTrial[3][1] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2X = self.currentTrial[4][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2Y = self.currentTrial[4][1] * (self.stimuliWidth/self.originalStimuliWidth);       
                self.t3X = self.currentTrial[5][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t3Y = self.currentTrial[5][1] * (self.stimuliWidth/self.originalStimuliWidth);                 
            }      
            if(self.currentTrial[2] == 4) {
                self.t1X = self.currentTrial[3][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t1Y = self.currentTrial[3][1] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2X = self.currentTrial[4][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t2Y = self.currentTrial[4][1] * (self.stimuliWidth/self.originalStimuliWidth);       
                self.t3X = self.currentTrial[5][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t3Y = self.currentTrial[5][1] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t4X = self.currentTrial[6][0] * (self.stimuliWidth/self.originalStimuliWidth);
                self.t4Y = self.currentTrial[6][1] * (self.stimuliWidth/self.originalStimuliWidth);                
            }                
            var imageString = "<img class=\"stimulus\" onclick=\"task.handleClick(event)\" src=\"" + "satellite-search-stimuli/" + self.currentTrial[0] + "\">";
            var allDoneButton = "<div id=\"searchCompleteButton\" class=\"button\" onclick=\"task.getTargetCount()\">Search Complete</div>"
            self.content.innerHTML = imageString + allDoneButton;
        }
    }
    
    function searchTask() {
        var self = this;
        this.originalStimuliWidth = 1833; // Width of stimuli that contains the locations of the targets.
        this.stimuliWidth = 1000; // Width of stimuli used by the task.
        this.distanceForFind = 10; // Max distance from a target a click can be for it to be considered a click on the target.
        this.maxTrialTime = 45000; // Search time allowed for each trial.
        this.countResults = [];
        this.clickResults = [];
        this.countDiffSum = 0;
        this.trialNumber = 0;
        this.clickCount = 0;
        this.content = document.getElementById("content");
        this.stimuliArray = <?php echo($stimuli_array); ?>;
    }
    
    window.onload = function() {
        task = new searchTask(); 
        task.startTask();
    }
    
    </script>
    <input type="hidden" name="count_results" value=""/>
    <input type="hidden" name="click_results" value=""/>
    <input type="hidden" name="mean_count_difference" value=""/>
    <input type="hidden" name="p_next" value="comp_survey"/>
    </fieldset>
    </form>
    <?php
}

function generateTrialList($n_stimuli) {
    $file_name = "satellite-search-stimulus-list.txt";
    $file = fopen($file_name, "r");
    $file_rows = fread($file, filesize($file_name));
    $file_rows = explode("\n", $file_rows);
    $file_rows = array_slice($file_rows, 1);
    shuffle($file_rows);
    $selected_rows = array();       # Create an array to hold the randomly selected stimuli in.
    $stimulus_count = 0;
    foreach($file_rows as $row) {
        $cols = explode("\t", $row);
        if($cols[1] == "Satellite" & $stimulus_count <= $n_stimuli-1) {
            array_push($selected_rows, $row);
            $stimulus_count++;
        }
    }
    $js_array = "[";
    foreach($selected_rows as $row) {
        $row = explode("\t", $row);
        $js_array .= "[\"$row[0]\", \"$row[1]\", $row[2], $row[3], $row[4], $row[5], $row[6]], ";
    }
    $js_array = trim($js_array, ", ");
    $js_array .= "]";
    fclose($file);
    return(array($js_array, $selected_rows));
}

function main() {
    search_task();
}

main();

?>
</div>
</body>
</html>