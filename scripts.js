// Typewriter created by Tameem Safi.
// source: https://github.com/tameemsafi/typewriterjs

var app = document.getElementById('app');

var typewriter = new Typewriter(app, {
    loop: true,
    delay:50,
    deleteSpeed:5
});

typewriter.typeString('hi, welcome to my personal website!')
    .pauseFor(1000)
    .deleteAll()
    .pauseFor(500)
    .typeString("i'm a student at USC studying computer science!")
    .pauseFor(1000)
    .deleteAll()
    .pauseFor(500)
    .typeString("i'm interested in software engineering and working on solutions to make information more accessible")
    .pauseFor(1000)
    .deleteAll()
    .pauseFor(500)
    .typeString("fun fact: i've hiked over 100 trails in my life!")
    .pauseFor(1000)
    .deleteAll()
    .pauseFor(500)
    .typeString("thanks for visiting:)")
    .pauseFor(1000)
    .deleteAll()
    .start();


    //algorithm taken from w3schools.com
    filterSelection("all")
    function filterSelection(c) {
      var x, i;
      x = document.getElementsByClassName("each-project");
      if (c == "all") c = "";
      for (i = 0; i < x.length; i++) {
        w3RemoveClass(x[i], "show");
        if (x[i].className.indexOf(c) > -1) w3AddClass(x[i], "show");
      }
    }
    
    function w3AddClass(element, name) {
      var i, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
      for (i = 0; i < arr2.length; i++) {
        console.log(element.className, arr2[i]);
        if (arr1.indexOf(arr2[i]) == -1) {element.className += " " + arr2[i];}
      }
    }
    
    function w3RemoveClass(element, name) {
      var i, arr1, arr2;
      arr1 = element.className.split(" ");
      arr2 = name.split(" ");
      for (i = 0; i < arr2.length; i++) {
        while (arr1.indexOf(arr2[i]) > -1) {
          arr1.splice(arr1.indexOf(arr2[i]), 1);     
        }
      }
      element.className = arr1.join(" ");
    }
    
    const btnContainer = document.getElementById("button-section");
    const btns = btnContainer.getElementsByClassName("filter-button");

    for (let i = 0; i < btns.length; i++) {
        btns[i].addEventListener("click", function() {
        // Remove active class from any previously active button
        const currentActive = btnContainer.querySelector(".active");
        if (currentActive) {
            currentActive.classList.remove("active");
        }
        // Add active class to the clicked button
        this.classList.add("active");
    });
}