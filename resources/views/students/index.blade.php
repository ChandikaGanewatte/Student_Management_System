
@extends('layouts.app')

@section('title', 'Student Management')

@section('content')
@php
    $page = $page ?? request('page', 'index');
@endphp

{{-- Success Message --}}
@if (session('success'))
    <div class="card">
        <p>{{ session('success') }}</p>
    </div>
@endif

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="card">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ADD STUDENT --}}
@if ($page === 'create')

    <div class="card">
        <h2>Add New Student</h2>

        <form action="{{ route('students.store') }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf

            <label for="name">Full Name *</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name') }}" required>

            <label for="email">Email Address *</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email') }}" required>

            <label for="phone">Phone Number</label>
            <input id="phone" type="text" name="phone"
                   value="{{ old('phone') }}">

            <label for="profile_image">Profile Photo (maximum 2 MB)</label>
            <input id="profile_image" type="file"
                   name="profile_image"
                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

            <button class="btn" type="submit">Save Student</button>
            <a class="btn secondary"
               href="{{ route('students.index') }}">Cancel</a>
        </form>
    </div>

{{-- EDIT STUDENT --}}
@elseif ($page === 'edit' && isset($student))

    <div class="card">
        <h2>Edit Student</h2>

        @if ($student->profile_image)
            <p>Current photo:</p>
            <img class="photo"
                 src="{{ asset('storage/' . $student->profile_image) }}"
                 alt="Current student photo">
        @endif

        <form action="{{ route('students.update', $student) }}"
              method="POST"
              enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <label for="name">Full Name *</label>
            <input id="name" type="text" name="name"
                   value="{{ old('name', $student->name) }}" required>

            <label for="email">Email Address *</label>
            <input id="email" type="email" name="email"
                   value="{{ old('email', $student->email) }}" required>

            <label for="phone">Phone Number</label>
            <input id="phone" type="text" name="phone"
                   value="{{ old('phone', $student->phone) }}">

            <label for="profile_image">
                Replace Profile Photo (optional, maximum 2 MB)
            </label>
            <input id="profile_image" type="file"
                   name="profile_image"
                   accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">

            <button class="btn" type="submit">Update Student</button>
            <a class="btn secondary"
               href="{{ route('students.index') }}">Cancel</a>
        </form>
    </div>

{{-- VIEW STUDENT --}}
@elseif ($page === 'show' && isset($student))

    <div class="card">
        <h2>Student Details</h2>

        @if ($student->profile_image)
            <img class="photo"
                 src="{{ asset('storage/' . $student->profile_image) }}"
                 alt="Photo of {{ $student->name }}"
                 style="width:140px;height:140px;object-fit:cover;border-radius:8px">
        @endif

        <p><strong>ID:</strong> {{ $student->id }}</p>
        <p><strong>Name:</strong> {{ $student->name }}</p>
        <p><strong>Email:</strong> {{ $student->email }}</p>
        <p><strong>Phone:</strong> {{ $student->phone ?: 'Not provided' }}</p>

        <a class="btn"
           href="{{ route('students.edit', $student) }}">Edit Student</a>
        <a class="btn secondary"
           href="{{ route('students.index') }}">Back to Students</a>
    </div>

{{-- STUDENT LIST --}}
@elseif ($page === 'deleted')

    <div class="card">
        <h2>Deleted Students</h2>
        <p>These records are hidden from the active student list.</p>

        <a class="btn secondary"
           href="{{ route('students.index') }}">
            Back to Active Students
        </a>
        <a class="btn secondary"
            href="{{ route('students.deleted') }}">
                View Deleted Students
        </a>
    </div>

    <div class="card table-wrap">
        @if ($students->isEmpty())
            <p>No deleted students found.</p>
        @else
            <table id="studentTable" class="sm-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>Deleted</td>
                            <td>
                                <form action="{{ route('students.restore', $student->id) }}"
                                      method="POST">
                                    @csrf

                                    <button type="submit" class="btn">
                                        Restore
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

@else


    <div class="sm-page-header">
        <div>
            <div class="sm-breadcrumb">Dashboard / Students</div>
            <h1>Student Management</h1>
            <p>Manage student profiles and registration records.</p>
        </div>

        <button type="button"
                class="sm-primary-btn"
                onclick="openModal('addStudentModal')">
            <span>＋</span> Add Student
        </button>
    </div>

    <div class="sm-toolbar">
        <div class="sm-search">
            <span aria-hidden="true">⌕</span>
            <input type="search"
                id="studentSearch"
                placeholder="Search by name, email or phone..."
                aria-label="Search students">
        </div>

        <span class="sm-record-label">
            Student directory
        </span>
    </div>

    <div class="card table-wrap">
        @if ($students->isEmpty())
            <p>No students found. Click "Add Student" to create your first record.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($students as $student)
                        <tr>
                            <td>
                                @if ($student->profile_image)
                                    <img class="photo"
                                         src="{{ asset('storage/' . $student->profile_image) }}"
                                         alt="Photo of {{ $student->name }}">
                                @else
                                    No photo
                                @endif
                            </td>

                            <td>{{ $student->name }}</td>
                            <td>{{ $student->email }}</td>
                            <td>{{ $student->phone ?: '—' }}</td>

                            <td>
                                <div class="actions">
                                    {{-- View Icon --}}
                                    <button type="button"
                                            class="icon-btn view-btn"
                                            title="View Student"
                                            aria-label="View Student"
                                            onclick="openModal('viewModal{{ $student->id }}')">
                                        <i class="fa-solid fa-eye"></i>
                                    </button>

                                    {{-- Edit Icon --}}
                                    <button type="button"
                                            class="icon-btn edit-btn"
                                            title="Edit Student"
                                            aria-label="Edit Student"
                                            onclick="openModal('editModal{{ $student->id }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </button>

                                    {{-- Delete Icon --}}
                                    <form action="{{ route('students.destroy', $student) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this student?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="icon-btn delete-btn"
                                                title="Delete Student"
                                                aria-label="Delete Student">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        
                        
                        {{-- Modern View Student Modal --}}
                        <div id="viewModal{{ $student->id }}" class="modal">
                            <div class="modal-content smart-view-card">

                                <button type="button"
                                        class="modal-close"
                                        onclick="closeModal('viewModal{{ $student->id }}')"
                                        aria-label="Close">
                                    &times;
                                </button>

                                <div class="student-profile-banner">
                                    <div class="student-profile-photo">
                                        @if ($student->profile_image)
                                            <img
                                                src="{{ asset('storage/' . $student->profile_image) }}"
                                                alt="Photo of {{ $student->name }}">
                                        @else
                                            <i class="fa-solid fa-user-graduate"></i>
                                        @endif
                                    </div>

                                    <h2>{{ $student->name }}</h2>
                                    <p>Student Profile</p>

                                    <span class="student-id-badge">
                                        <i class="fa-solid fa-id-card"></i>
                                        Student ID: {{ $student->id }}
                                    </span>
                                </div>

                                <div class="student-info-panel">
                                    <h3>
                                        <i class="fa-regular fa-address-card"></i>
                                        Personal Information
                                    </h3>

                                    <div class="student-info-item">
                                        <div class="student-info-icon">
                                            <i class="fa-regular fa-user"></i>
                                        </div>
                                        <div class="student-info-text">
                                            <span>Full Name</span>
                                            <strong>{{ $student->name }}</strong>
                                        </div>
                                    </div>

                                    <div class="student-info-item">
                                        <div class="student-info-icon">
                                            <i class="fa-regular fa-envelope"></i>
                                        </div>
                                        <div class="student-info-text">
                                            <span>Email Address</span>
                                            <strong>{{ $student->email }}</strong>
                                        </div>
                                    </div>

                                    <div class="student-info-item">
                                        <div class="student-info-icon">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>
                                        <div class="student-info-text">
                                            <span>Phone Number</span>
                                            <strong>{{ $student->phone ?: 'Not provided' }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="smart-view-actions">
                                    <button type="button"
                                            class="smart-view-close"
                                            onclick="closeModal('viewModal{{ $student->id }}')">
                                        <i class="fa-solid fa-xmark"></i>
                                        Close
                                    </button>

                                    <button type="button"
                                            class="smart-view-edit"
                                            onclick="closeModal('viewModal{{ $student->id }}'); openModal('editModal{{ $student->id }}')">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                        Edit Student
                                    </button>
                                </div>

                            </div>
                        </div>
                      
                        {{-- Modern Edit Student Modal --}}
                        <div id="editModal{{ $student->id }}" class="modal">
                            <div class="modal-content smart-edit-card">

                                <button type="button"
                                        class="modal-close"
                                        onclick="closeModal('editModal{{ $student->id }}')"
                                        aria-label="Close">
                                    &times;
                                </button>

                                <div class="smart-edit-header">
                                    <div class="smart-edit-icon">
                                        <i class="fa-solid fa-user-pen"></i>
                                    </div>
                                    <div>
                                        <h2>Edit Student</h2>
                                        <p>Update the student's profile information.</p>
                                    </div>
                                </div>

                                <div class="edit-student-reference">
                                    <i class="fa-solid fa-id-card"></i>
                                    Editing Student #{{ $student->id }}
                                </div>

                                <form action="{{ route('students.update', $student) }}"
                                    method="POST"
                                    enctype="multipart/form-data"
                                    class="modern-student-form">

                                    @csrf
                                    @method('PUT')

                                    <div class="form-section-title">
                                        <i class="fa-regular fa-address-card"></i>
                                        Personal Information
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="edit_name_{{ $student->id }}">
                                            Full Name <span>*</span>
                                        </label>
                                        <div class="modern-input-wrap">
                                            <i class="fa-regular fa-user"></i>
                                            <input id="edit_name_{{ $student->id }}"
                                                type="text"
                                                name="name"
                                                value="{{ $student->name }}"
                                                placeholder="Enter student's full name"
                                                required>
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="edit_email_{{ $student->id }}">
                                            Email Address <span>*</span>
                                        </label>
                                        <div class="modern-input-wrap">
                                            <i class="fa-regular fa-envelope"></i>
                                            <input id="edit_email_{{ $student->id }}"
                                                type="email"
                                                name="email"
                                                value="{{ $student->email }}"
                                                placeholder="student@example.com"
                                                required>
                                        </div>
                                    </div>

                                    <div class="modern-form-group">
                                        <label for="edit_phone_{{ $student->id }}">
                                            Phone Number
                                        </label>
                                        <div class="modern-input-wrap">
                                            <i class="fa-solid fa-phone"></i>
                                            <input id="edit_phone_{{ $student->id }}"
                                                type="tel"
                                                name="phone"
                                                value="{{ $student->phone }}"
                                                placeholder="Enter phone number">
                                        </div>
                                    </div>

                                    <div class="form-section-title photo-section-title">
                                        <i class="fa-regular fa-image"></i>
                                        Profile Photo
                                    </div>

                                    <div class="photo-upload-area">
                                        <div class="photo-preview"
                                            id="editPhotoPreview{{ $student->id }}">
                                            @if ($student->profile_image)
                                                <img
                                                    src="{{ asset('storage/' . $student->profile_image) }}"
                                                    alt="Current student photo">
                                            @else
                                                <i class="fa-solid fa-cloud-arrow-up"></i>
                                            @endif
                                        </div>

                                        <div class="photo-upload-details">
                                            <label for="edit_photo_{{ $student->id }}">
                                                Change profile photo
                                            </label>
                                            <p>Choose a new photo, or keep the current one.</p>

                                            <input id="edit_photo_{{ $student->id }}"
                                                type="file"
                                                name="profile_image"
                                                accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                                        </div>
                                    </div>

                                    <div class="modern-form-actions">
                                        <button type="button"
                                                class="form-cancel-btn"
                                                onclick="closeModal('editModal{{ $student->id }}')">
                                            <i class="fa-solid fa-xmark"></i>
                                            Cancel
                                        </button>

                                        <button type="submit" class="form-save-btn">
                                            <i class="fa-solid fa-floppy-disk"></i>
                                            Save Changes
                                        </button>
                                    </div>

                                </form>
                            </div>
                        </div>

                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    
    
    {{-- Modern Add Student Modal --}}
    <div id="addStudentModal" class="modal">
        <div class="modal-content add-student-card">

            <button type="button"
                    class="modal-close"
                    onclick="closeModal('addStudentModal')"
                    aria-label="Close form">
                &times;
            </button>

            <div class="add-form-header">
                <div class="add-form-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div>
                    <h2>Add New Student</h2>
                    <p>Enter the student's information below.</p>
                </div>
            </div>

            <form action="{{ route('students.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="modern-student-form">

                @csrf

                <div class="form-section-title">
                    <i class="fa-regular fa-address-card"></i>
                    Personal Information
                </div>

                <div class="modern-form-group">
                    <label for="add_name">Full Name <span>*</span></label>
                    <div class="modern-input-wrap">
                        <i class="fa-regular fa-user"></i>
                        <input id="add_name"
                            type="text"
                            name="name"
                            placeholder="Enter student's full name"
                            value="{{ old('name') }}"
                            required>
                    </div>
                </div>

                <div class="modern-form-group">
                    <label for="add_email">Email Address <span>*</span></label>
                    <div class="modern-input-wrap">
                        <i class="fa-regular fa-envelope"></i>
                        <input id="add_email"
                            type="email"
                            name="email"
                            placeholder="student@example.com"
                            value="{{ old('email') }}"
                            required>
                    </div>
                </div>

                <div class="modern-form-group">
                    <label for="add_phone">Phone Number</label>
                    <div class="modern-input-wrap">
                        <i class="fa-solid fa-phone"></i>
                        <input id="add_phone"
                            type="tel"
                            name="phone"
                            placeholder="Enter phone number"
                            value="{{ old('phone') }}">
                    </div>
                </div>

                <div class="form-section-title photo-section-title">
                    <i class="fa-regular fa-image"></i>
                    Profile Photo
                </div>

                <div class="photo-upload-area">
                    <div class="photo-preview" id="addPhotoPreview">
                        <i class="fa-solid fa-cloud-arrow-up"></i>
                    </div>

                    <div class="photo-upload-details">
                        <label for="add_profile_image">
                            Upload student photo
                        </label>
                        <p>JPG, PNG or WEBP · Maximum 2 MB</p>

                        <input id="add_profile_image"
                            type="file"
                            name="profile_image"
                            accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp">
                    </div>
                </div>

                <div class="modern-form-actions">
                    <button type="button"
                            class="form-cancel-btn"
                            onclick="closeModal('addStudentModal')">
                        Cancel
                    </button>

                    <button type="submit" class="form-save-btn">
                        <i class="fa-solid fa-check"></i>
                        Save Student
                    </button>
                </div>

            </form>
        </div>
    </div>

@endif


<style>
    .sm-page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        margin-bottom: 26px;
        flex-wrap: wrap;
    }

    .sm-breadcrumb {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 8px;
    }

    .sm-page-header h1 {
        margin: 0 0 8px;
        color: #172033;
        font-size: clamp(24px, 3vw, 32px);
        font-weight: 750;
        letter-spacing: -0.7px;
    }

    .sm-page-header p {
        color: #64748b;
        margin: 0;
        font-size: 14px;
    }

    .sm-primary-btn {
        background: #4f46e5;
        color: white;
        border: none;
        border-radius: 10px;
        padding: 12px 18px;
        font-size: 14px;
        font-weight: 600;
        cursor: pointer;
        box-shadow: 0 4px 10px rgba(79, 70, 229, .16);
        transition: background .2s, transform .2s;
    }

    .sm-primary-btn:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }

    .sm-toolbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 14px;
        margin-bottom: 18px;
        flex-wrap: wrap;
    }

    .sm-search {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 0 14px;
        max-width: 460px;
        width: 100%;
    }

    .sm-search span {
        font-size: 23px;
        color: #64748b;
    }

    .sm-search input {
        border: none;
        outline: none;
        box-shadow: none;
        width: 100%;
        padding: 13px 0;
        background: transparent;
        color: #172033;
        font-size: 14px;
    }

    .sm-search:focus-within {
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, .12);
    }

    .sm-record-label {
        color: #64748b;
        font-size: 13px;
    }

    .table-wrap:has(.sm-table) {
        background: white;
        border: 1px solid #e8edf4;
        border-radius: 14px;
        padding: 0;
        overflow-x: auto;
        box-shadow: 0 5px 20px rgba(15, 23, 42, .04);
    }

    .sm-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 700px;
    }

    .sm-table thead {
        background: #f8fafc;
    }

    .sm-table th {
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: .6px;
        padding: 16px;
        text-align: left;
        border-bottom: 1px solid #e8edf4;
        white-space: nowrap;
    }

    .sm-table td {
        padding: 15px 16px;
        color: #334155;
        font-size: 13px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .sm-table tbody tr {
        transition: background .15s;
    }

    .sm-table tbody tr:hover {
        background: #f8faff;
    }

    .sm-table tbody tr:last-child td {
        border-bottom: none;
    }

    .sm-table .photo {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #e2e8f0;
    }

    .sm-table .actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
    }

    .sm-table .btn {
        border-radius: 7px;
        padding: 7px 10px;
        font-size: 12px;
        white-space: nowrap;
    }

    @media (max-width: 640px) {
        .sm-page-header {
            align-items: stretch;
        }

        .sm-primary-btn {
            width: 100%;
        }

        .sm-toolbar {
            align-items: stretch;
        }
    }

    
    /* Student action icon buttons */
    .sm-table .actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .sm-table .actions form {
        display: inline-flex;
        margin: 0;
    }

    .icon-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid transparent;
        border-radius: 9px;
        cursor: pointer;
        font-size: 15px;
        transition: all 0.2s ease;
    }

    /* View - blue */
    .view-btn {
        color: #2563eb;
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .view-btn:hover {
        color: #ffffff;
        background: #2563eb;
    }

    /* Edit - orange */
    .edit-btn {
        color: #d97706;
        background: #fffbeb;
        border-color: #fef3c7;
    }

    .edit-btn:hover {
        color: #ffffff;
        background: #d97706;
    }

    /* Delete - red */
    .delete-btn {
        color: #dc2626;
        background: #fef2f2;
        border-color: #fee2e2;
    }

    .delete-btn:hover {
        color: #ffffff;
        background: #dc2626;
    }

    .icon-btn:focus-visible {
        outline: 3px solid #a5b4fc;
        outline-offset: 2px;
    }

    
    /* ===== Modern Add Student Form ===== */

    .add-student-card {
        width: min(560px, 94vw);
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        border: 1px solid #e8edf5;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.18);
        box-sizing: border-box;
    }

    .add-form-header {
        display: flex;
        align-items: center;
        gap: 15px;
        padding-bottom: 23px;
        margin-bottom: 24px;
        border-bottom: 1px solid #edf0f5;
    }

    .add-form-icon {
        width: 52px;
        height: 52px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        background: linear-gradient(135deg, #6366f1, #4338ca);
        border-radius: 15px;
        font-size: 21px;
        box-shadow: 0 7px 16px rgba(79, 70, 229, 0.2);
    }

    .add-form-header h2 {
        margin: 0 0 6px;
        color: #172033;
        font-size: 23px;
        font-weight: 750;
        letter-spacing: -0.5px;
    }

    .add-form-header p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.5;
    }

    .form-section-title {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 19px;
        color: #334155;
        font-size: 14px;
        font-weight: 700;
    }

    .form-section-title > i {
        color: #6366f1;
        font-size: 16px;
    }

    .modern-form-group {
        margin-bottom: 19px;
    }

    .modern-form-group > label {
        display: block;
        margin-bottom: 8px;
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .modern-form-group > label span {
        color: #dc2626;
    }

    .modern-input-wrap {
        display: flex;
        align-items: center;
        gap: 11px;
        min-height: 47px;
        padding: 0 14px;
        border: 1px solid #dce3ed;
        border-radius: 10px;
        background: #f8fafc;
        box-sizing: border-box;
        transition: border-color 0.2s, box-shadow 0.2s,
                    background 0.2s;
    }

    .modern-input-wrap > i {
        width: 17px;
        flex-shrink: 0;
        color: #94a3b8;
        font-size: 15px;
    }

    .modern-input-wrap input {
        width: 100%;
        min-width: 0;
        padding: 13px 0;
        border: none;
        outline: none;
        box-shadow: none;
        background: transparent;
        color: #172033;
        font-size: 13px;
    }

    .modern-input-wrap input::placeholder {
        color: #a0aabc;
    }

    .modern-input-wrap:focus-within {
        background: #ffffff;
        border-color: #818cf8;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.12);
    }

    .photo-section-title {
        margin-top: 25px;
    }

    .photo-upload-area {
        display: flex;
        align-items: center;
        gap: 16px;
        padding: 18px;
        margin-bottom: 25px;
        border: 1px dashed #c7d2fe;
        border-radius: 13px;
        background: #f8faff;
    }

    .photo-preview {
        width: 65px;
        height: 65px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        border-radius: 13px;
        color: #6366f1;
        background: #e0e7ff;
        font-size: 23px;
    }

    .photo-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .photo-upload-details {
        flex: 1;
        min-width: 0;
    }

    .photo-upload-details label {
        display: block;
        margin-bottom: 6px;
        color: #334155;
        font-size: 13px;
        font-weight: 700;
    }

    .photo-upload-details p {
        margin: 0 0 9px;
        color: #64748b;
        font-size: 11px;
    }

    .photo-upload-details input[type="file"] {
        display: block;
        width: 100%;
        max-width: 100%;
        color: #475569;
        font-size: 11px;
    }

    .modern-form-actions {
        display: flex;
        justify-content: flex-end;
        gap: 11px;
        padding-top: 20px;
        border-top: 1px solid #edf0f5;
    }

    .form-cancel-btn,
    .form-save-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 43px;
        padding: 0 17px;
        border-radius: 9px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 650;
        transition: all 0.2s ease;
    }

    .form-cancel-btn {
        border: 1px solid #dce3ed;
        color: #475569;
        background: #ffffff;
    }

    .form-cancel-btn:hover {
        background: #f1f5f9;
    }

    .form-save-btn {
        border: 1px solid #4f46e5;
        color: #ffffff;
        background: #4f46e5;
        box-shadow: 0 4px 10px rgba(79, 70, 229, 0.15);
    }

    .form-save-btn:hover {
        background: #4338ca;
        transform: translateY(-1px);
    }

    @media (max-width: 480px) {
        .add-student-card {
            padding: 23px 18px;
            border-radius: 15px;
        }

        .add-form-header h2 {
            font-size: 20px;
        }

        .photo-upload-area {
            align-items: flex-start;
            padding: 12px;
        }

        .modern-form-actions > button {
            flex: 1;
            padding: 0 10px;
        }
    }

    
    /* ===== Smart View Student Modal ===== */

    .smart-view-card {
        width: min(500px, 94vw);
        max-width: 500px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 0;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.18);
    }

    .student-profile-banner {
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 32px 22px 25px;
        color: white;
        text-align: center;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        border-radius: 20px 20px 0 0;
    }

    .student-profile-photo {
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        margin-bottom: 13px;
        border: 4px solid rgba(255,255,255,.75);
        border-radius: 50%;
        color: #6366f1;
        background: #e0e7ff;
        font-size: 38px;
        box-shadow: 0 5px 18px rgba(15,23,42,.15);
    }

    .student-profile-photo img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .student-profile-banner h2 {
        margin: 0 0 6px;
        color: #ffffff;
        font-size: 23px;
        font-weight: 750;
        overflow-wrap: anywhere;
    }

    .student-profile-banner > p {
        margin: 0 0 14px;
        color: #e0e7ff;
        font-size: 13px;
    }

    .student-id-badge {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        padding: 7px 12px;
        border: 1px solid rgba(255,255,255,.25);
        border-radius: 20px;
        color: white;
        background: rgba(255,255,255,.14);
        font-size: 12px;
        font-weight: 600;
    }

    .student-info-panel {
        padding: 24px;
    }

    .student-info-panel h3 {
        display: flex;
        align-items: center;
        gap: 9px;
        margin: 0 0 18px;
        color: #172033;
        font-size: 15px;
    }

    .student-info-panel h3 i {
        color: #6366f1;
    }

    .student-info-item {
        display: flex;
        align-items: center;
        gap: 13px;
        padding: 13px 0;
        border-bottom: 1px solid #edf0f5;
    }

    .student-info-item:last-child {
        border-bottom: none;
    }

    .student-info-icon {
        width: 40px;
        height: 40px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 11px;
        color: #4f46e5;
        background: #eef2ff;
    }

    .student-info-text {
        min-width: 0;
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .student-info-text span {
        color: #64748b;
        font-size: 11px;
    }

    .student-info-text strong {
        color: #1e293b;
        font-size: 13px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .smart-view-actions {
        display: flex;
        justify-content: flex-end;
        flex-wrap: wrap;
        gap: 10px;
        padding: 17px 24px 23px;
        border-top: 1px solid #edf0f5;
    }

    .smart-view-actions button {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        min-height: 40px;
        padding: 0 15px;
        border-radius: 9px;
        cursor: pointer;
        font-size: 12px;
        font-weight: 650;
        transition: .2s ease;
    }

    .smart-view-close {
        color: #475569;
        background: white;
        border: 1px solid #dce3ed;
    }

    .smart-view-close:hover {
        background: #f1f5f9;
    }

    .smart-view-edit {
        color: white;
        background: #4f46e5;
        border: 1px solid #4f46e5;
    }

    .smart-view-edit:hover {
        background: #4338ca;
    }


    /* ===== Smart Edit Student Modal ===== */

    .smart-edit-card {
        width: min(560px, 94vw);
        max-width: 560px;
        max-height: 90vh;
        overflow-y: auto;
        padding: 30px;
        border: 1px solid #e8edf5;
        border-radius: 20px;
        background: #ffffff;
        box-shadow: 0 24px 70px rgba(15, 23, 42, 0.18);
        box-sizing: border-box;
    }

    .smart-edit-header {
        display: flex;
        align-items: center;
        gap: 14px;
        padding-bottom: 20px;
        margin-bottom: 18px;
        border-bottom: 1px solid #edf0f5;
    }

    .smart-edit-icon {
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 14px;
        color: white;
        background: linear-gradient(135deg, #4f46e5, #7c3aed);
        font-size: 20px;
    }

    .smart-edit-header h2 {
        margin: 0 0 6px;
        color: #172033;
        font-size: 22px;
        font-weight: 750;
    }

    .smart-edit-header p {
        margin: 0;
        color: #64748b;
        font-size: 12px;
        line-height: 1.5;
    }

    .edit-student-reference {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin-bottom: 23px;
        padding: 8px 12px;
        border-radius: 8px;
        color: #4338ca;
        background: #eef2ff;
        font-size: 12px;
        font-weight: 650;
    }

    .smart-edit-card .modal-close {
        z-index: 2;
    }

    @media (max-width: 480px) {
        .smart-edit-card {
            padding: 23px 18px;
        }

        .student-info-panel {
            padding: 20px;
        }

        .smart-view-actions {
            padding: 15px 20px 20px;
        }

        .smart-view-actions button {
            flex: 1;
            padding: 0 10px;
        }
    }


</style>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const searchInput = document.getElementById('studentSearch');
    const studentTable = document.getElementById('studentTable');

    if (!searchInput || !studentTable) return;

    searchInput.addEventListener('input', function () {
        const query = this.value.trim().toLowerCase();

        studentTable.querySelectorAll('tbody tr').forEach(function (row) {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(query) ? '' : 'none';
        });
    });
});

document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll(
        'input[id^="edit_photo_"]'
    ).forEach(function (input) {

        input.addEventListener('change', function () {
            const file = this.files[0];
            const studentId = this.id.replace('edit_photo_', '');

            const preview = document.getElementById(
                'editPhotoPreview' + studentId
            );

            if (!file || !preview) return;

            if (!file.type.startsWith('image/')) {
                alert('Please select an image file.');
                this.value = '';
                return;
            }

            if (file.size > 2 * 1024 * 1024) {
                alert('The image must be smaller than 2 MB.');
                this.value = '';
                return;
            }

            const reader = new FileReader();

            reader.onload = function (event) {
                preview.innerHTML = '';

                const img = document.createElement('img');
                img.src = event.target.result;
                img.alt = 'New student photo preview';

                preview.appendChild(img);
            };

            reader.readAsDataURL(file);
        });
    });
});

</script>

@endsection