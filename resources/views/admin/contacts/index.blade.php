@extends('layouts.admin')

@section('title', 'Contact Messages')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Contact Messages</h3>
  <span class="badge bg-warning text-dark fs-6">
    {{ $messages->total() }} total
  </span>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show">
  {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card">
  <div class="table-responsive">
    <table class="table table-hover align-middle mb-0" id="contactsTable">
      <thead class="table-light">
        <tr>
          <th style="width:90px">Status</th>
          <th>Name</th>
          <th>Email</th>
          <th>Subject</th>
          <th style="width:160px">Date</th>
          <th class="text-end" style="width:120px">Actions</th>
        </tr>
      </thead>
      <tbody>
        @forelse($messages as $message)
        <tr id="row-{{ $message->id }}" class="{{ $message->is_read ? '' : 'fw-semibold' }}">
          <td>
            <span id="badge-{{ $message->id }}" class="badge rounded-pill bg-{{ $message->is_read ? 'secondary' : 'warning text-dark' }}">
              {{ $message->is_read ? 'Read' : 'Unread' }}
            </span>
          </td>
          <td>{{ $message->name }}</td>
          <td class="text-secondary">{{ $message->email }}</td>
          <td class="text-truncate" style="max-width:200px" title="{{ $message->subject }}">{{ $message->subject }}</td>
          <td class="text-secondary small">{{ $message->created_at->format('Y-m-d H:i') }}</td>
          <td class="text-end">
            <button type="button"
              class="btn btn-sm btn-primary contact-view-btn"
              data-id="{{ $message->id }}"
              data-url="{{ route('admin.contacts.show', $message) }}"
              data-markread-url="{{ route('admin.contacts.mark-read', $message) }}"
              data-delete-url="{{ route('admin.contacts.destroy', $message) }}">
              <i class="bi bi-eye"></i> View
            </button>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="6" class="text-center py-5 text-secondary">
            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
            No contact messages found.
          </td>
        </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@if($messages->hasPages())
<div class="mt-3 d-flex justify-content-center">
  {{ $messages->links() }}
</div>
@endif

{{-- ── Message Modal ── --}}
<div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-content">

      <div class="modal-header border-0 pb-0">
        <div>
          <span id="modalBadge" class="badge rounded-pill mb-1"></span>
          <h5 class="modal-title mb-0" id="contactModalLabel">Message</h5>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <div class="modal-body pt-2" id="modalBody">
        {{-- Loading skeleton --}}
        <div id="modalLoading" class="py-4 text-center text-secondary">
          <div class="spinner-border spinner-border-sm me-2" role="status"></div> Loading…
        </div>

        {{-- Content (hidden while loading) --}}
        <div id="modalContent" style="display:none">
          <div class="row g-2 mb-3 text-sm">
            <div class="col-sm-6">
              <label class="text-secondary small mb-0">From</label>
              <div class="fw-semibold" id="modalName"></div>
            </div>
            <div class="col-sm-6">
              <label class="text-secondary small mb-0">Email</label>
              <div><a id="modalEmail" href="#" class="text-decoration-none"></a></div>
            </div>
            <div class="col-sm-6">
              <label class="text-secondary small mb-0">Subject</label>
              <div class="fw-semibold" id="modalSubject"></div>
            </div>
            <div class="col-sm-6">
              <label class="text-secondary small mb-0">Received</label>
              <div class="text-secondary small" id="modalDate"></div>
            </div>
          </div>
          <hr class="my-2">
          <label class="text-secondary small mb-1">Message</label>
          <div id="modalMessage"
            style="background:#f8f9ff;border-radius:8px;padding:1rem 1.1rem;white-space:pre-wrap;line-height:1.7;font-size:.93rem;border:1px solid #eeeef5;">
          </div>
        </div>
      </div>

      <div class="modal-footer border-0 pt-0 gap-2" id="modalFooter">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-success d-none" id="modalMarkReadBtn">
          <i class="bi bi-check2-circle me-1"></i>Mark as Read
        </button>
        <a id="modalReplyBtn" href="#" class="btn btn-outline-primary">
          <i class="bi bi-reply me-1"></i>Reply
        </a>
        <button type="button" class="btn btn-danger" id="modalDeleteBtn">
          <i class="bi bi-trash me-1"></i>Delete
        </button>
      </div>

    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
  (function() {
    var modal = new bootstrap.Modal(document.getElementById('contactModal'));
    var modalEl = document.getElementById('contactModal');
    var currentId = null;
    var currentDeleteUrl = null;
    var currentMarkReadUrl = null;

    // ── Open modal & fetch data ──
    document.querySelectorAll('.contact-view-btn').forEach(function(btn) {
      btn.addEventListener('click', function() {
        currentId = this.dataset.id;
        currentDeleteUrl = this.dataset.deleteUrl;
        currentMarkReadUrl = this.dataset.markreadUrl;

        // Reset modal state
        document.getElementById('modalLoading').style.display = '';
        document.getElementById('modalContent').style.display = 'none';
        document.getElementById('modalMarkReadBtn').classList.add('d-none');
        document.getElementById('modalBadge').textContent = '';
        document.getElementById('modalBadge').className = 'badge rounded-pill mb-1';

        modal.show();

        fetch(this.dataset.url, {
            headers: {
              'Accept': 'application/json',
              'X-Requested-With': 'XMLHttpRequest'
            }
          })
          .then(function(r) {
            return r.json();
          })
          .then(function(d) {
            document.getElementById('modalName').textContent = d.name;
            document.getElementById('modalEmail').textContent = d.email;
            document.getElementById('modalEmail').href = 'mailto:' + d.email;
            document.getElementById('modalSubject').textContent = d.subject;
            document.getElementById('modalDate').textContent = d.created_at;
            document.getElementById('modalMessage').textContent = d.message;
            document.getElementById('modalReplyBtn').href = 'mailto:' + d.email + '?subject=Re: ' + encodeURIComponent(d.subject);

            var badge = document.getElementById('modalBadge');
            if (d.is_read) {
              badge.textContent = 'Read';
              badge.classList.add('bg-secondary');
            } else {
              badge.textContent = 'Unread';
              badge.classList.add('bg-warning', 'text-dark');
              document.getElementById('modalMarkReadBtn').classList.remove('d-none');
            }

            // Update table row badge (was unread, now auto-marked read on open)
            var rowBadge = document.getElementById('badge-' + d.id);
            var row = document.getElementById('row-' + d.id);
            if (rowBadge) {
              rowBadge.textContent = 'Read';
              rowBadge.className = 'badge rounded-pill bg-secondary';
            }
            if (row) row.classList.remove('fw-semibold');

            document.getElementById('modalLoading').style.display = 'none';
            document.getElementById('modalContent').style.display = '';
          })
          .catch(function() {
            document.getElementById('modalLoading').innerHTML =
              '<span class="text-danger"><i class="bi bi-exclamation-circle me-1"></i>Failed to load message.</span>';
          });
      });
    });

    // ── Mark as Read ──
    document.getElementById('modalMarkReadBtn').addEventListener('click', function() {
      if (!currentMarkReadUrl) return;
      var self = this;
      self.disabled = true;

      fetch(currentMarkReadUrl, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
            'X-HTTP-Method-Override': 'PATCH',
            'X-CSRF-TOKEN': document.querySelector('meta[name=csrf-token]') ? document.querySelector('meta[name=csrf-token]').content : ''
          },
          body: new URLSearchParams({
            _method: 'PATCH',
            _token: getCsrf()
          })
        })
        .then(function(r) {
          return r.json();
        })
        .then(function(d) {
          if (d.success) {
            self.classList.add('d-none');
            var badge = document.getElementById('modalBadge');
            badge.textContent = 'Read';
            badge.className = 'badge rounded-pill mb-1 bg-secondary';
            var rowBadge = document.getElementById('badge-' + currentId);
            var row = document.getElementById('row-' + currentId);
            if (rowBadge) {
              rowBadge.textContent = 'Read';
              rowBadge.className = 'badge rounded-pill bg-secondary';
            }
            if (row) row.classList.remove('fw-semibold');
          }
        })
        .finally(function() {
          self.disabled = false;
        });
    });

    // ── Delete ──
    document.getElementById('modalDeleteBtn').addEventListener('click', function() {
      if (!confirm('Delete this message? This cannot be undone.')) return;
      var self = this;
      self.disabled = true;

      fetch(currentDeleteUrl, {
          method: 'POST',
          headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: new URLSearchParams({
            _method: 'DELETE',
            _token: getCsrf()
          })
        })
        .then(function(r) {
          return r.json();
        })
        .then(function(d) {
          if (d.success) {
            modal.hide();
            var row = document.getElementById('row-' + currentId);
            if (row) {
              row.style.transition = 'opacity .3s';
              row.style.opacity = '0';
              setTimeout(function() {
                row.remove();
              }, 300);
            }
          }
        })
        .finally(function() {
          self.disabled = false;
        });
    });

    function getCsrf() {
      var m = document.querySelector('meta[name=csrf-token]');
      if (m) return m.content;
      var i = document.querySelector('input[name=_token]');
      return i ? i.value : '';
    }
  }());
</script>
@endpush