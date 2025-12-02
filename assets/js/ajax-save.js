jQuery(document).ready(function ($) {
  const $form = document.querySelector(".wrap form")
  const $myBtnMessage = document.getElementById("mi-boton-estado")

  $form.addEventListener("submit", function (e) {
    e.preventDefault()

    e.target.querySelector('input[type="submit"]').disabled = true
    $myBtnMessage.textContent = "Guardando..."

    const formData = new FormData($form)
    const urlEncodedData = new URLSearchParams()

    formData.forEach((value, key) => {
      urlEncodedData.append(key, value)
    })

    // enviar TODO dentro de 'data'
    const params = new URLSearchParams()
    params.append("action", "mi_boton_guardar_ajax")
    params.append("nonce", miBotonAjax.nonce)
    params.append("data", urlEncodedData.toString()) // <--- clave 'data'

    fetch(miBotonAjax.ajax_url, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: params.toString(),
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          $myBtnMessage.textContent = "¡Cambios guardados!"
          setTimeout(() => {
            $myBtnMessage.textContent = ""
          }, 3000)
        } else console.log("Error al guardar la configuración: " + data.data)
      })
      .catch((err) => {
        console.error(err)
        $myBtnMessage.textContent = "Error al guardar la configuración."
      })
      .finally(() => {
        e.target.querySelector('input[type="submit"]').disabled = false
      })
  })
})
