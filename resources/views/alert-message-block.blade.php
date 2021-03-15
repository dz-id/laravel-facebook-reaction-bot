@if ($message = session("alert_success"))
<div class="alert alert-success alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ $message }}
    </div>
</div>
@endif
@if ($message = session("alert_danger"))
<div class="alert alert-danger alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ $message }}
    </div>
</div>
@endif
@if ($message = session("alert_warning"))
<div class="alert alert-warning alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ $message }}
    </div>
</div>
@endif
@if ($message = session("alert_info"))
<div class="alert alert-info alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ $message }}
    </div>
</div>
@endif
@if ($message = session("alert_secondary"))
<div class="alert alert-secondary alert-dismissible show fade">
    <div class="alert-body">
        <button class="close" data-dismiss="alert">
            <span>×</span>
        </button>
        {{ $message }}
    </div>
</div>
@endif