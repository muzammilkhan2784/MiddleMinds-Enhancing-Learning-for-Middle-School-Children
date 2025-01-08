<?php
session_start();

// Define static questions for Science and General Knowledge
$scienceQuestions = [
    1 => [
        ["The tiny structures inside the nucleus of a cell that contain genetic information are called _______.", "chromosomes"],
        ["Animals that eat both plants and animals are called _______.", "omnivores"],
        ["The transfer of thermal energy through radiant waves is called _______.", "radiation"],
        ["The study of human anatomy is the examination of the _______ structure of the human body.", "physical"],
        ["The process by which plants lose water vapor through their stomata is called _______.", "transpiration"],
        ["A mixture that can be separated into its components by physical means is called a _______.", "heterogeneous mixture"],
        ["The study of the behavior of animals is called _______.", "ethology"],
        ["The process by which organisms adapt to their environment is called _______.", "adaptation"],
        ["The study of diseases is called _______.", "pathology"],
        ["The process by which vaccines work is by exposing the body to a weakened or inactive form of a virus or bacteria to _______ immunity.", "develop"],
        ["A group of similar cells working together to perform a specific function is called a _______.", "tissue"],
        ["The part of the plant responsible for absorbing water and nutrients from the soil is the _______.", "root"],
        ["The study of rocks and minerals is called _______.", "geology"],
        ["The process by which plants release oxygen and take in carbon dioxide is called _______.", "respiration"],
        ["The force that pulls objects towards the center of the Earth is called _______.", "gravity"],
        ["The number of protons found in the nucleus of an atom is called its _______.", "atomic number"],
        ["The Earth's outer layer is divided into several rigid pieces called _______.", "tectonic plates"],
        ["The process of a liquid changing into a gas is called _______.", "evaporation"],
        ["The substance that gives plants their green color and helps them in photosynthesis is _______.", "chlorophyll"],
        ["The study of the Earth's atmosphere and weather is called _______.", "meteorology"]
    ],
    2 => [
        ["The basic unit of life is the _______.", "cell"],
        ["Water exists in three states: solid, liquid, and _______.", "gas"],
        ["The process of changing from a gas to a liquid is called _______.", "condensation"],
        ["The force that opposes motion between two surfaces that are touching each other is called _______.", "friction"],
        ["The branch of science that deals with the study of the universe beyond Earth's atmosphere is called _______.", "astronomy"],
        ["The study of matter and its motion through space and time is called _______.", "physics"],
        ["The process of combining two or more substances to form a new substance with different properties is called _______.", "chemical reaction"],
        ["The process by which plants and some other organisms use sunlight to convert carbon dioxide and water into food is called _______.", "photosynthesis"],
        ["The number of protons found in the nucleus of an atom is called its _______.", "atomic number"],
        ["The center of an atom, which contains protons and neutrons, is called the _______.", "nucleus"],
        ["The substance that cannot be broken down into simpler substances by chemical means is called a _______.", "element"],
        ["The outermost layer of the Earth is called the _______.", "crust"],
        ["The amount of matter in an object is called its _______.", "mass"],
        ["The study of the movement and effects of heat is called _______.", "thermodynamics"],
        ["The process by which organisms produce offspring of the same kind is called _______.", "reproduction"],
        ["The process by which plants make their own food using sunlight, carbon dioxide, and water is called _______.", "photosynthesis"],
        ["The study of the structure and properties of matter is called _______.", "chemistry"],
        ["The force that pulls objects towards each other is called _______.", "attraction"],
        ["The process of a solid changing directly into a gas without passing through the liquid state is called _______.", "sublimation"],
        ["The study of the Earth's history and the processes that have shaped it is called _______.", "geology"]
    ],
    3 => [
        ["The unit of measurement for electric current is _______.", "ampere"],
        ["The process of combining oxygen with other substances to produce energy is called _______.", "oxidation"],
        ["The process of a liquid changing into a solid is called _______.", "freezing"],
        ["The substance that carries genetic information and determines an organism's traits is called _______.", "DNA"],
        ["The process by which organisms change over time in response to their environment is called _______.", "evolution"],
        ["The branch of science that deals with the study of the Earth's structure and the processes that shape it is called _______.", "geology"],
        ["The study of the movement and distribution of water on Earth is called _______.", "hydrology"],
        ["The process by which an organism grows and develops is called _______.", "growth"],
        ["The branch of science that deals with the study of living organisms is called _______.", "biology"],
        ["The branch of science that deals with the study of sound is called _______.", "acoustics"],
        ["The study of the composition, structure, and properties of matter is called _______.", "chemistry"],
        ["The process by which an organism produces energy from food is called _______.", "metabolism"],
        ["The process of changing from a solid directly into a gas without passing through the liquid state is called _______.", "sublimation"],
        ["The branch of science that deals with the study of light is called _______.", "optics"],
        ["The process by which rocks are broken down into smaller pieces is called _______.", "weathering"],
        ["The study of the Earth's atmosphere and climate is called _______.", "climatology"],
        ["The process by which new plants grow from seeds is called _______.", "germination"],
        ["The substance that makes up the majority of Earth's atmosphere is _______.", "nitrogen"],
        ["The study of the Earth's magnetic field and its effects is called _______.", "geomagnetism"],
        ["The process by which an organism reacts to changes in its environment is called _______.", "response"]
    ],
];

$generalKnowledgeQuestions = [
    1 => [
        ["What has four legs and meows?", "cat"],
        ["How many colors are in a rainbow?", "7"],
        ["The Earth goes around the sun once in a year", "true"],
        ["What do you call a baby kangaroo?", "joey"],
        ["What is the biggest ocean on Earth?", "Pacific Ocean"],
        ["What has hands but cannot clap?", "clock"],
        ["What white fluffy stuff falls from the sky in winter?", "Snow"],
        ["What do you call a group of lions?", "pride of lions"],
        ["How many sides does a square have?", "4"],
        ["What do you wear on your feet to keep them warm?", "Socks"],
        ["What is the capital of France?", "Paris"],
        ["What do butterflies come from?", "Caterpillars"],
        ["What has a long neck and likes to eat leaves?", "giraffe"],
        ["What shiny object reflects your face?", "mirror"],
        ["How many days are in a week?", "7"],
        ["What do you call a baby cow?", "calf"],
        ["What gets wet when it dries?", "towel"],
        ["What has keys but no doors?", "piano"],
        ["What has a shell and lives in the ocean?", "turtle"],
    ],
    2 => [
        ["What country has the Great Wall of China?", "China"],
        ["What is the name of the round, bright object in the night sky?", "moon"],
        ["What do you call a vehicle with two wheels?", "bicycle"],
        ["What is the tallest mountain in the world?", "Mount Everest"],
        ["What do clouds turn into when they fall from the sky?", "Rain"],
        ["What warm-blooded animal lays eggs?", "bird"],
        ["How many strings does a violin typically have?", "4"],
        ["What is the name of the story of Noah's Ark?", "Book of Genesis"],
        ["What do firefighters wear when they fight fires?", "uniform"],
        ["What is the capital of the United States?", "Washington D.C."],
        ["What is the name of the biggest desert in the world?", "Sahara Desert"],
        ["What is the name of the long, twisting structure in a snail?", "shell"],
        ["What do you call a group of zebras?", "A dazzle of zebras"],
        ["What country is famous for its red double-decker buses?", "United Kingdom"],
        ["What is the name of the instrument a dentist uses to check your teeth?", "mirror"],
        ["What do stars turn into when they die?", "Black holes"],
        ["What is the name of the largest bone in the human body?", "femur"]
    ],
    3 => [
        ["What is the name of the first person to walk on the moon?", "Neil Armstrong"],
        ["What is the name of the largest building in the world by floor area?", "Burj Khalifa"],
        ["What is the name of the biggest rainforest in the world?", "Amazon Rainforest"],
        ["What is the name of the largest planet in our solar system?", "Jupiter"],
        ["What is the scientific name for a butterfly?", "Lepidoptera"],
        ["What is the name of the period in history characterized by the development of writing?", "Bronze Age"],
        ["What is the largest freshwater lake by volume?", "Lake Baikal"],
        ["What country is home to the Colosseum?", "Italy"],
        ["What is the name of the largest continent on Earth?", "Africa"],
        ["What is the process called when a caterpillar transforms into a butterfly?", "Metamorphosis"],
        ["What is the name of the largest ocean on Earth by surface area?", "Pacific Ocean"],
        ["What is the name of the scientific study of weather?", "Meteorology"],
        ["What is the name of the curved path the Earth takes around the sun?", "orbit"],
        ["What is the name of the largest land animal on Earth?", "Elephant"],
        ["What is the name of the instrument a pilot uses to fly a plane?", "yoke"],
        ["What is the name of the largest country in the world by land area?", "Russia"],
        ["What is the name of the largest hot desert in the world?", "Sahara Desert"],
        ["What is another name for a large, hot desert with little rainfall?", "wasteland"]
    ]
];

// Function to generate math questions based on level
function generateMathQuestion($level)
{
    $operations = ['+', '-', '*', '/'];
    $digits = $level;  // Adjust the number of digits based on the level
    $num1 = rand(10 ** ($digits - 1), 10 ** $digits - 1);
    $num2 = rand(1, 10 ** $digits - 1); // Avoid zero in division
    $operation = $operations[array_rand($operations)];

    // Adjust numbers to ensure integer results for division
    if ($operation == '/') {
        $num2 = $num2 + 1;
        $num1 = $num1 + 1;

        if ($level === 1 || $level === 2) {
            $num2 = $num2 % 10;
        }
        $num2 = $num2 % 100;
        $num1 = $num1 % 100;
        $num1 = $num1 * $num2; // Ensure result is an integer
    }

    $question = "$num1 $operation $num2";
    $answer = eval("return $question;"); // Evaluate the expression
    if ($operation == '/') {
        $answer = intval($answer); // Ensure answer is integer if division
    }
    return ["question" => $question . " = ?", "answer" => strval($answer)];
}
function generateChoices($correctAnswer, $allAnswers) {
    $choices = [$correctAnswer];
    $keys = array_rand($allAnswers, 3); // Adjust the number for more or fewer options
    foreach ($keys as $key) {
        if (!in_array($allAnswers[$key], $choices)) {
            $choices[] = $allAnswers[$key];
        }
    }
    shuffle($choices); // Shuffle the choices to make the options randomized
    return $choices;
}

function getAllPossibleAnswers($questions) {
    $answers = [];
    foreach ($questions as $questionSet) {
        foreach ($questionSet as $q) {
            $answers[] = $q[1]; // Collect all answers to use as incorrect choices
        }
    }
    return $answers;
}
$category = $_GET['category'] ?? 'Math';
$level = $_GET['level'] ?? 1;

if ($category == 'Science') {
    $allAnswers = getAllPossibleAnswers($scienceQuestions);
    $index = array_rand($scienceQuestions[$level]);
    $question = $scienceQuestions[$level][$index][0];
    $answer = $scienceQuestions[$level][$index][1];
    $choices = generateChoices($answer, $allAnswers);
} elseif ($category == 'General Knowledge') {
    $allAnswers = getAllPossibleAnswers($generalKnowledgeQuestions);
    $index = array_rand($generalKnowledgeQuestions[$level]);
    $question = $generalKnowledgeQuestions[$level][$index][0];
    $answer = $generalKnowledgeQuestions[$level][$index][1];
    $choices = generateChoices($answer, $allAnswers);
} elseif ($category == 'Math') {
    $result = generateMathQuestion($level);
    $question = $result['question'];
    $answer = $result['answer'];

} else {
    $question = "Invalid category or level";
    $answer = "";
    $choices = [];
}


$_SESSION['answer'] = $answer; // Store the correct answer in the session to validate later in submit.php
$_SESSION['current_category'] = $category; // Store current category for score calculation

echo json_encode(["question" => $question, "answer" => $answer]);
