<script>
  $(function() {
    // array untuk menyimpan daftar item pesanan
    const orderedList = []
    // tombol submit order
    const $submitBtn = $('#submit-order')

    // helper: format angka ke Rupiah untuk tampilan
    const fmtRp = (n) => 'Rp ' + Number(n).toLocaleString('id-ID')

    // fungsi untuk update total, payload hidden, dan state tombol submit
    function refreshCartState() {
      const totalSum = orderedList.reduce((s, it) => s + Number(it.price), 0)
      $('#total-cell').text(fmtRp(totalSum))
      $('#order_payload').val(JSON.stringify({
        items: orderedList,
        total: totalSum
      }))
      $submitBtn.prop('disabled', orderedList.length === 0)
    }

    // awalnya tombol submit disabled (keranjang kosong)
    $submitBtn.prop('disabled', true)

    // event handler tombol Add produk
    $('.btn-add').on('click', function(e) {
      e.preventDefault()
      const $card = $(this).closest('.card-body')
      const name = $card.find('.card-title').text().trim()
      const price = Number($card.find('.id_product').data('price'))
      const id = Number($card.find('.id_product').val())

      // cek apakah produk sudah ada di orderedList
      const idx = orderedList.findIndex(it => it.id === id)
      if (idx === -1) {
        // produk baru → push ke orderedList
        orderedList.push({
          id,
          name,
          qty: 1,
          unitPrice: price,
          price
        })
        // tambahkan baris baru ke tabel keranjang
        $('#tbl-cart tbody').append(`
        <tr data-id="${id}">
          <td>${name}</td>
          <td class="qty">1</td>
          <td class="price">${fmtRp(price)}</td>
        </tr>
      `)
      } else {
        // produk sudah ada → update qty dan total price
        orderedList[idx].qty += 1
        orderedList[idx].price = orderedList[idx].qty * orderedList[idx].unitPrice
        // update tampilan di tabel
        const $row = $(`#tbl-cart tbody tr[data-id="${id}"]`)
        $row.find('.qty').text(orderedList[idx].qty)
        $row.find('.price').text(fmtRp(orderedList[idx].price))
      }

      // refresh total dan payload
      refreshCartState()
    })

    // tombol Submit Order → tampilkan modal konfirmasi
    $('#submit-order').on('click', function(e) {
      e.preventDefault()
      if (orderedList.length === 0) {
        alert('Keranjang kosong. Tambahkan produk terlebih dahulu.')
        return
      }
      // tampilkan total di modal
      $('#confirm-total').text(fmtRp(
        orderedList.reduce((s, it) => s + Number(it.price), 0)
      ))
      // buka modal Bootstrap
      const confirmModal = new bootstrap.Modal(document.getElementById('confirmSubmitModal'))
      confirmModal.show()
    })

    // tombol Confirm di modal → kirim AJAX ke backend
   $('#confirm-submit-btn').on('click', function() {
    const $btn = $(this)
    $btn.prop('disabled', true).text('Mengirim...')

    const form = document.getElementById('order-form')
    const fd = new FormData(form)

    // ⬇⬇⬇ WAJIB TAMBAH INI 🔥
    fd.append('customer_id', $('#member_id').val())
    // ⬆⬆⬆ WAJIB TAMBAH INI 🔥

    fetch(form.action, {
        method: 'POST',
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: fd,
        credentials: 'same-origin'
    })
    .then(async res => {
        const contentType = res.headers.get('content-type') || ''
        let data = null
        if (contentType.includes('application/json')) {
            data = await res.json()
        }

        if (!res.ok || (data && data.success === false)) {
            alert((data && data.message) ? data.message : 'Gagal menyimpan pesanan')
            $btn.prop('disabled', false).text('Ya, Simpan')
            return
        }

        if (data && data.print_url) {
            window.location.href = data.print_url
        } else if (res.redirected) {
            window.location.href = res.url
        } else {
            window.location.reload()
        }
    })
    .catch(err => {
        console.error(err)
        alert('Terjadi kesalahan: ' + (err.message || ''))
        $btn.prop('disabled', false).text('Ya, Simpan')
    })
})

  })
</script>