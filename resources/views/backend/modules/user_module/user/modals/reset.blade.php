<div class="modal-header">
    <h5 class="modal-title" id="exampleModalLabel">Reset Password</h5>
    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>

<div class="modal-body">
    <form class="ajax-form" method="post" action="{{ route('user.reset', $user->id) }}">
        @csrf

        <div class="row">

            <!-- confirm password -->
            <div class="col-md-6 col-12 form-group password-box">
                <i class="fas fa-eye show-password"></i>
                <i class="fas fa-eye-slash hide-password"></i>
                <label>Password</label><span class="require-span">*</span>
                <input type="password" class="form-control" name="password" id="password-field">
            </div>

            <!-- confirm password -->
            <div class="col-md-6 col-12 form-group password-box">
                <i class="fas fa-eye show-password"></i>
                <i class="fas fa-eye-slash hide-password"></i>
                <label>Confirm Password</label><span class="require-span">*</span>
                <input type="password" class="form-control" name="password_confirmation" id="password-field">
            </div>

            <div class="col-md-12 form-group text-right">
                <button type="submit" class="btn btn-outline-dark">
                    Reset
                </button>
            </div>

        </div>
    </form>
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
</div>



<script>
    $(".show-password").click(function() {
        let $this = $(this)
        $this.closest(".password-box").find("#password-field").attr("type", "text")
        $this.closest(".password-box").find(".show-password").hide()
        $this.closest(".password-box").find(".hide-password").show()
    })

    $(".hide-password").click(function() {
        let $this = $(this)
        $this.closest(".password-box").find("#password-field").attr("type", "password")
        $this.closest(".password-box").find(".show-password").show()
        $this.closest(".password-box").find(".hide-password").hide()
    })
</script>