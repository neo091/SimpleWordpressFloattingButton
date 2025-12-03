jQuery(document).ready(function ($) {
  const $form = document.querySelector("#btn-settings")
  const $svg = document.querySelector("#btn-svg")
  const $exclude = document.querySelector("#btn-exclude")

  $form.addEventListener("submit", function (e) {
    e.preventDefault()

    e.target.querySelector('input[type="submit"]').disabled = true
    e.target.querySelector("div#simple-wp-floating-button-estado").textContent =
      "Guardando..."

    const formData = new FormData(e.target)
    const urlEncodedData = new URLSearchParams()

    formData.forEach((value, key) => {
      urlEncodedData.append(key, value)
    })

    // enviar TODO dentro de 'data'
    const params = new URLSearchParams()
    params.append(
      "action",
      "simple_wp_floating_button_save_ajax_tabs_config_btn"
    )
    params.append("nonce", miBotonAjax.nonce)
    params.append("data", urlEncodedData.toString()) // <--- clave 'data'

    console.log(urlEncodedData.toString())

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
          e.target.querySelector(
            "div#simple-wp-floating-button-estado"
          ).textContent = "Cambios guardados!"
          setTimeout(() => {
            e.target.querySelector(
              "div#simple-wp-floating-button-estado"
            ).textContent = ""
          }, 3000)
        } else {
          console.log("Error al guardar la configuración: " + data.data)
          e.target.querySelector(
            "div#simple-wp-floating-button-estado"
          ).textContent = "Error al guardar la configuración."
        }
      })
      .catch((err) => {
        console.error(err)
        e.target.querySelector(
          "div#simple-wp-floating-button-estado"
        ).textContent = "Error al guardar la configuración."
      })
      .finally(() => {
        e.target.querySelector('input[type="submit"]').disabled = false
      })
  })

  $svg.addEventListener("submit", function (e) {
    e.preventDefault()

    const submitButton = e.target.querySelector('input[type="submit"]')
    const statusElement = e.target.querySelector(
      "div#simple-wp-floating-button-estado"
    )

    const formData = new FormData(e.target)
    const urlEncodedData = new URLSearchParams()

    formData.forEach((value, key) => {
      urlEncodedData.append(key, value)
    })

    // enviar TODO dentro de 'data'
    const params = new URLSearchParams()
    params.append(
      "action",
      "simple_wp_floating_button_save_ajax_tabs_config_svg"
    )
    params.append("nonce", miBotonAjax.nonce)
    params.append("data", urlEncodedData.toString()) // <--- clave 'data'

    fetchUpdated(params.toString(), submitButton, statusElement)
  })

  $exclude.addEventListener("submit", function (e) {
    e.preventDefault()

    const submitButton = e.target.querySelector('input[type="submit"]')
    const statusElement = e.target.querySelector(
      "div#simple-wp-floating-button-estado"
    )

    const formData = new FormData(e.target)
    const urlEncodedData = new URLSearchParams()

    formData.forEach((value, key) => {
      urlEncodedData.append(key, value)
    })

    // enviar TODO dentro de 'data'
    const params = new URLSearchParams()
    params.append(
      "action",
      "simple_wp_floating_button_save_ajax_tabs_config_exclude"
    )
    params.append("nonce", miBotonAjax.nonce)
    params.append("data", urlEncodedData.toString()) // <--- clave 'data'

    fetchUpdated(params.toString(), submitButton, statusElement)
  })

  function fetchUpdated(data, submitButton, statusElement) {
    submitButton.disabled = true
    statusElement.textContent = "Guardando..."

    fetch(miBotonAjax.ajax_url, {
      method: "POST",
      headers: {
        "Content-Type": "application/x-www-form-urlencoded; charset=UTF-8",
      },
      body: data,
    })
      .then((res) => res.json())
      .then((data) => {
        if (data.success) {
          statusElement.textContent = "Cambios guardados!"
          setTimeout(() => {
            statusElement.textContent = ""
          }, 3000)
        } else {
          console.log("Error al guardar la configuración: " + data.data)
          statusElement.textContent = "Error al guardar la configuración."
        }
      })
      .catch((err) => {
        console.error(err)
        statusElement.textContent = "Error al guardar la configuración."
      })
      .finally(() => {
        submitButton.disabled = false
      })
  }
})
