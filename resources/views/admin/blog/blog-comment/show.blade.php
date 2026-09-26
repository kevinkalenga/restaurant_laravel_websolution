@extends('admin.layouts.master')

@section('content')

<section class="section">

    <div class="section-header">
        <h1>Comment Details</h1>
    </div>

    <div class="card card-primary">

        <div class="card-header">
            <h4>Comment Details</h4>
        </div>

        <div class="card-body">

            <div class="row">

                <div class="col-md-6">
                    <strong>User</strong>
                    <p>
                        {{ $comment->user ? $comment->user->name : '-' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Blog</strong>
                    <p>
                        {{ $comment->blog ? $comment->blog->title : '-' }}
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Status</strong>
                    <p>
                        @if($comment->status)
                            <span class="badge badge-success">
                                Approved
                            </span>
                        @else
                            <span class="badge badge-warning">
                                Disapproved
                            </span>
                        @endif
                    </p>
                </div>

                <div class="col-md-6">
                    <strong>Created At</strong>
                    <p>
                        {{ $comment->created_at->format('d/m/Y H:i') }}
                    </p>
                </div>

                <div class="col-md-12">
                    <strong>Comment</strong>

                    <div class="border rounded p-3 mt-2">
                        {{ $comment->comment }}
                    </div>
                </div>

            </div>

        </div>

        <div class="card-footer">

            <a href="{{ route('admin.blogs.comments.index') }}"
               class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Back
            </a>

        </div>

    </div>

</section>

@endsection