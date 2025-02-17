$(document).ready(function () {
  $('.click_mwnu').click(function () {
    $('.sidebar_open').toggleClass('show_side')
  })
})

let typeSpans = document.querySelectorAll('.type_span')

typeSpans.forEach(type_span => {
  let textArray = type_span.dataset.typetext.split('')
  let counter = -1
  type_span.innerHTML = ''

  function typeJs () {
    if (counter < type_span.dataset.typetext.length) {
      counter++
      type_span.innerHTML += type_span.dataset.typetext.charAt(counter)
      textArray = type_span.dataset.typetext.split('')
    } else {
      textArray.pop()
      type_span.innerHTML = textArray.join('')
      if (textArray.length == 0) {
        counter = -1
      }
    }
  }

  setInterval(() => {
    typeJs()
  }, 300)
})
