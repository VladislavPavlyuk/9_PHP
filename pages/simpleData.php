<?php
require "feedbackLib.php";
echo $FEED->save("XYZ Course Feedback", [
  ["Are the course materials sufficient?", "R"],
  ["How likely are you to recommend this course to friends?", "R"],
  ["Any other feedback on the course?", "O"]
], "Optional description")
? "OK" : $FEED->error;