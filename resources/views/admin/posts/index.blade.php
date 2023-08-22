@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-12">

            <table class="table table-dark table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">Id</th>
                        <th scope="col">Title</th>
                        <th scope="col">Slug</th>
                        <th scope="col">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $posts as $post )
                        <tr>
                            <th>
                                {{ $post->id }}
                            </th>
                            <td>
                                <strong>
                                    {{ $post->title }}
                                </strong>
                            </td>
                            <td>
                                {{ $post->slug }}
                            </td>
                            <td>
                                <a href="" class="btn btn-sm btn-primary">
                                    View
                                </a>
                                <a href="" class="btn btn-sm btn-success">
                                    Edit
                                </a>
                                <a href="" class="btn btn-sm btn-warning">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    @endforeach

                </tbody>

            </table>

            {{ $posts->links() }}

        </div>
    </div>
</div>
@endsection
