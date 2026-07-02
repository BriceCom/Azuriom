@extends('admin.layouts.admin')

@section('title', trans('trackurl::admin.links.title'))

@section('content')
    <div class="col-12 mb-3 d-flex flex-column gap-2">
        <ul class="list-unstyled d-flex flex-wrap gap-2">
            <li>
                <a href="https://github.com/Bricec6/Azuriom-Plugin-Trackurl" target="_blank" class="btn bg-white text-black fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-github me-1"></i>{{trans('trackurl::admin.contribute')}}</a>
            </li>
            <li>
                <a href="https://discord.gg/Gh2yBxUWvV" target="_blank" class="btn btn-primary fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-discord me-1"></i>{{trans('trackurl::admin.support')}}</a>
            </li>
            <li>
                <a href="https://www.serveurliste.com" target="_blank" class="btn btn-warning fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-search-heart-fill me-1"></i>{{trans('trackurl::admin.serveurliste')}}</a>
            </li>
            <li>
                <a href="https://discord.gg/4feP35urSB" target="_blank" class="btn btn-success fw-bold rounded-4 text-uppercase px-3"><i class="bi bi-fire me-1"></i>{{trans('trackurl::admin.custom_theme')}}</a>
            </li>
        </ul>
        <hr>
    </div>
    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive pb-5">
                <table class="table table-striped align-middle">
                    <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.name') }}</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.short_code') }}</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.destination_url') }}</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.clicks') }}</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.created_at') }}</th>
                        <th scope="col">{{ trans('trackurl::admin.fields.user') }}</th>
                        <th scope="col">{{ trans('messages.fields.status') }}</th>
                        <th scope="col">{{ trans('messages.fields.action') }}</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($links as $link)
                        <tr>
                            <th scope="row">{{ $link->id }}</th>
                            <td>{{ $link->name }}</td>
                            <td>
                                <div class="d-flex align-items-center">
                                    <a href="{{ route('trackurl.redirect', $link->short_code) }}" target="_blank" class="me-2">
                                        {{ $link->short_code }}
                                    </a>
                                    <div class="dropdown me-2">
                                        <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="urlFormatDropdown{{ $link->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="bi bi-link-45deg"></i> {{ trans('trackurl::messages.url_format') }}
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="urlFormatDropdown{{ $link->id }}">
                                            <li>
                                                <button type="button" class="dropdown-item copy-btn"
                                                    data-url="{{ route('trackurl.redirect', $link->short_code) }}">
                                                    <i class="bi bi-clipboard"></i> {{ trans('trackurl::messages.copy_standard') }}
                                                </button>
                                            </li>
                                            <li>
                                                <button type="button" class="dropdown-item copy-btn"
                                                    data-url="{{ url('/').'/?ref='.$link->short_code }}">
                                                    <i class="bi bi-clipboard"></i> {{ trans('trackurl::messages.copy_pretty') }}
                                                </button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <a href="{{ $link->destination_url }}" target="_blank" class="text-truncate d-inline-block" style="max-width: 200px;">
                                    {{ $link->destination_url }}
                                </a>
                            </td>
                            <td>{{ $link->clicks_count }}</td>
                            <td>{{ format_date($link->created_at) }}</td>
                            <td>{{ $link->user->name }}</td>
                            <td>
                                @if($link->blocked)
                                    <span class="badge bg-danger">{{ trans('trackurl::admin.links.status.blocked') }}</span>
                                @else
                                    <span class="badge bg-success">{{ trans('trackurl::admin.links.status.active') }}</span>
                                @endif
                            </td>
                            <td class="text-nowrap">
                                <a href="{{ route('trackurl.admin.edit', $link) }}" class="btn btn-primary btn-sm">
                                    <i class="bi bi-pencil"></i> {{ trans('messages.actions.edit') }}
                                </a>
                                <a href="{{ route('trackurl.admin.stats', $link) }}" class="btn btn-info btn-sm">
                                    <i class="bi bi-bar-chart"></i> {{ trans('trackurl::admin.links.stats') }}
                                </a>
                                <form action="{{ route('trackurl.admin.toggle-block', $link) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-{{ $link->blocked ? 'success' : 'warning' }} btn-sm">
                                        <i class="bi bi-{{ $link->blocked ? 'unlock' : 'lock' }}"></i>
                                        {{ trans('trackurl::admin.links.actions.' . ($link->blocked ? 'unblock' : 'block')) }}
                                    </button>
                                </form>
                                <a href="{{ route('trackurl.admin.destroy', $link) }}" class="btn btn-danger btn-sm" data-confirm="delete">
                                    <i class="bi bi-trash"></i> {{ trans('messages.actions.delete') }}
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            {{ $links->links() }}

            <div class="mb-3">
                <a class="btn btn-primary" href="{{ route('trackurl.admin.create') }}">
                    <i class="bi bi-plus-lg"></i> {{ trans('trackurl::admin.links.create') }}
                </a>
            </div>
        </div>
    </div>

    <hr>

    <div class="d-flex align-items-start gap-4 flex-wrap">
        <iframe width="560" height="315" src="https://www.youtube.com/embed/yy-kjejVAyc?si=PDcpfyXoTFE5QQHr" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>

        <div class="d-flex flex-column align-items-start gap-3">
                <i class="bi bi-graph-up-arrow fs-3"></i>
                <div>
                    <h2>
                        {{ trans('trackurl::admin.advanced_section.title') }}
                    </h2>
                    <p class="mb-0 text-muted">
                        {{ trans('trackurl::admin.advanced_section.description') }}
                        <a href="https://lank.li/trackurl" target="_blank" rel="noopener noreferrer">https://lank.li/trackurl</a>
                    </p>
                </div>

                <a href="https://lank.li/trackurl" target="_blank" rel="noopener noreferrer" class="btn btn-primary fw-bold text-uppercase">
                   {{ trans('trackurl::admin.advanced_section.cta') }} <i class="bi bi-box-arrow-up-right ms-1"></i>
                </a>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all copy buttons
            const copyButtons = document.querySelectorAll('.copy-btn');

            // Add click event listener to each button
            copyButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the URL to copy
                    const url = this.getAttribute('data-url');

                    // Create a temporary input element
                    const tempInput = document.createElement('input');
                    tempInput.value = url;
                    document.body.appendChild(tempInput);

                    // Select and copy the text
                    tempInput.select();
                    document.execCommand('copy');

                    // Remove the temporary input
                    document.body.removeChild(tempInput);

                    // Change button text to show feedback
                    const originalHTML = this.innerHTML;
                    this.innerHTML = '<i class="bi bi-clipboard-check"></i> {{ trans('trackurl::messages.copied') }}';

                    // Reset button text after 2 seconds
                    setTimeout(() => {
                        this.innerHTML = originalHTML;
                    }, 2000);
                });
            });
        });
    </script>
@endpush
