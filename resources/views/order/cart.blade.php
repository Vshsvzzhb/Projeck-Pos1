<form id="order-form" method="POST" action="{{ url('order') }}">
  @csrf
  <div class="mb-2">
    <label for="member_id" class="form-label">Pelanggan</label>
    <select name="member_id" id="member_id" class="form-select form-select-sm">
      @foreach($member as $c)
      <option value="{{ $c->id }}">{{ $c->name }}</option>
      @endforeach
    </select>
  </div>

  <table class="table table-sm align-middle" id="tbl-cart">
    <thead>
      <tr>
        <th>Produk</th>
        <th>Qty</th>
        <th>Price</th>
      </tr>
    </thead>
    <tbody>

    </tbody>
    <tfoot>
      <tr>
        <td colspan="2" class="text-end"><strong>Total</strong></td>
        <td id="total-cell">0</td>
      </tr>
    </tfoot>
  </table>

  <input type="hidden" name="order_payload" id="order_payload" value="">
  <button type="button" id="submit-order" class="btn btn-success">Submit Order</button>
</form>

<!-- Modal Konfirmasi -->
<div class="modal fade" id="confirmSubmitModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Konfirmasi Pesanan</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        <p>Total pesanan: <strong id="confirm-total">Rp 0</strong></p>
        <p>Apakah Anda yakin ingin menyimpan pesanan ini?</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
        <button type="button" id="confirm-submit-btn" class="btn btn-primary">Ya, Simpan</button>
      </div>
    </div>
  </div>
</div>