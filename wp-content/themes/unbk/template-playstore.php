<?php /* Template Name: Halaman Konfirmasi */ ?>
<?php global $headerclass;
$headerclass = "playstore" ?>
<?php include('header.php');
print_header() ?>

<script>
  const soalPlayStore = [{
      "question": "What is the capital city of France?",
      "options": {
        "A": "Paris",
        "B": "Berlin",
        "C": "Rome",
        "D": "Madrid"
      },
      "answer": "A"
    },
    {
      "question": "Which planet is known as the Red Planet?",
      "options": {
        "A": "Mars",
        "B": "Venus",
        "C": "Jupiter",
        "D": "Saturn"
      },
      "answer": "A"
    },
    {
      "question": "Who wrote 'Romeo and Juliet'?",
      "options": {
        "A": "William Shakespeare",
        "B": "Charles Dickens",
        "C": "Jane Austen",
        "D": "Mark Twain"
      },
      "answer": "A"
    },
    {
      "question": "What is the largest ocean on Earth?",
      "options": {
        "A": "Pacific Ocean",
        "B": "Atlantic Ocean",
        "C": "Indian Ocean",
        "D": "Arctic Ocean"
      },
      "answer": "A"
    },
    {
      "question": "What is the boiling point of water at sea level in Celsius?",
      "options": {
        "A": "100°C",
        "B": "90°C",
        "C": "80°C",
        "D": "70°C"
      },
      "answer": "A"
    },
    {
      "question": "Which element has the chemical symbol 'O'?",
      "options": {
        "A": "Oxygen",
        "B": "Gold",
        "C": "Osmium",
        "D": "Oganesson"
      },
      "answer": "A"
    },
    {
      "question": "Which country hosted the 2016 Summer Olympics?",
      "options": {
        "A": "Brazil",
        "B": "China",
        "C": "United Kingdom",
        "D": "Russia"
      },
      "answer": "A"
    },
    {
      "question": "What is the smallest prime number?",
      "options": {
        "A": "2",
        "B": "1",
        "C": "3",
        "D": "0"
      },
      "answer": "A"
    },
    {
      "question": "Who painted the Mona Lisa?",
      "options": {
        "A": "Leonardo da Vinci",
        "B": "Vincent van Gogh",
        "C": "Pablo Picasso",
        "D": "Claude Monet"
      },
      "answer": "A"
    },
    {
      "question": "Which gas do plants primarily absorb from the atmosphere for photosynthesis?",
      "options": {
        "A": "Carbon Dioxide",
        "B": "Oxygen",
        "C": "Nitrogen",
        "D": "Hydrogen"
      },
      "answer": "A"
    }
  ]
  let s = "";
  for (let i = 0; i < soalPlayStore.length; i++) {
    s += /*html*/ `
        <div class="questions" id="questions-${i}" style="margin-bottom:50px">
          <div class="question" style="border: solid 1px #ccc; padding:10px; border-radius: 5px;">${i+1}. ${soalPlayStore[i].question}</div>
          <div style="margin-left:20px; margin-bottom: 10px; margin-top: 20px;">Choose the correct answer</div>
          <div class="option-a" style="margin-left:20px; margin-bottom:10px"><input type="radio" name="soal-${i}" id="soal-${i}-a" /> <label for="soal-${i}-a">${soalPlayStore[i].options.A}</label></div>
          <div class="option-b" style="margin-left:20px; margin-bottom:10px"><input type="radio" name="soal-${i}" id="soal-${i}-b" /> <label for="soal-${i}-b">${soalPlayStore[i].options.B}</label></div>
          <div class="option-c" style="margin-left:20px; margin-bottom:10px"><input type="radio" name="soal-${i}" id="soal-${i}-c" /> <label for="soal-${i}-c">${soalPlayStore[i].options.C}</label></div>
          <div class="option-d" style="margin-left:20px; margin-bottom:10px"><input type="radio" name="soal-${i}" id="soal-${i}-d" /> <label for="soal-${i}-d">${soalPlayStore[i].options.D}</label></div>
        </div>`
  }
</script>

<div class="container">
  <div class="row">
    <div class="col">
      <div style="background: #fff; padding: 20px;" id="bodySoal">
      </div>
      <div class="text-center">
        <button class="btn btn-primary" style="margin-top: 20px; padding:10px 50px" id="submitbtn">Submit</button>
      </div>
    </div>
  </div>
</div>

<script>
  document.getElementById('bodySoal').innerHTML = s;
  document.getElementById("submitbtn").addEventListener("click", function() {
    let score = 0;
    for (let i = 0; i < soalPlayStore.length; i++) {
      let jawaban = soalPlayStore[i].answer;
      let selected = document.querySelector(`input[name=soal-${i}]:checked`);
      if (selected) {
        if (selected.id === `soal-${i}-${jawaban.toLowerCase()}`) {
          score++;
        }
      }
    }
    alert(`Your score is ${score * 10}`);
    window.location.href = "./ceknilai---"
  })
</script>

<?php include('footer.php');
print_footer(); ?>