<div class="col-md-6 col-lg-4">
    <div class="rotating-card-container manual-flip" style="height: 328.875px; margin-bottom: 30px;">
        <div class="card card-rotate">
            <div class="front" style="min-height: 328.875px;">
                <div class="card-content">
                    <h5 class="category-social text-success">
                        <i class="fa fa-newspaper-o"></i> {{ $post->job_title }}
                    </h5>
                    <h4 class="card-title">
                        <a href="#pablo">{{ $languages }}</a>
                    </h4>
                    <p class="card-description">
                    </p>
                    <div class="footer" style="display: flex; align-items: center; justify-content: space-between">
                        <div class="author">
                            <a href="#pablo">
                                <img src="{{ $company->logo }}" class="avatar img-raised">
                                <span>{{ $company->name }}</span>
                            </a>
                        </div>
                        <button type="button" name="button"
                                class="btn btn-sm btn-success btn-fill btn-round btn-rotate">
                            <i class="material-icons">refresh</i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="back" style="min-height: 328.875px;">
                <div class="card-content">
                    <br>
                    <h5 class="card-title">
                        {{ __('frontpage.location') }}
                    </h5>
                    <p class="card-description">
                        {{ $post->location }}
                    </p>
                    <div class="footer text-center">
                        <a href="#pablo" class="btn btn-rose btn-round">
                            <i class="material-icons">subject</i> Read
                        </a>
                        <a href="#pablo" class="btn btn-just-icon btn-round btn-twitter">
                            <i class="fa fa-twitter"></i>
                        </a>
                        <a href="#pablo" class="btn btn-just-icon btn-round btn-dribbble">
                            <i class="fa fa-dribbble"></i>
                        </a>
                        <a href="#pablo" class="btn btn-just-icon btn-round btn-facebook">
                            <i class="fa fa-facebook"></i>
                        </a>
                    </div>
                    <br>
                    <button type="button" name="button" class="btn btn-simple btn-round btn-rotate">
                        <i class="material-icons">refresh</i> Back...
                        <div class="ripple-container"></div>
                    </button>

                </div>
            </div>

        </div>
    </div>
</div>
