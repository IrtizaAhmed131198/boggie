<?php

namespace App\Http\Controllers\Admin;

use App\User;

use App\Product;
use App\Certificate;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CertificateController extends Controller
{
    public function index()
    {
        $course = certificate::with('user', 'course')->get();
        // return $course;
        return view('admin.certificate.index', compact('course'));
    }

    public function create()
    {
        return view('admin.certificate.create');
    }

    public function store(Request $request)
    {
        // Corrected validation rule
        $request->validate([
            'user_id' => 'required',
            'course_id' => 'required',
            'status' => 'required'
        ]);

        // Retrieve values from the request
        $userId = $request->input('user_id');
        $productId = $request->input('course_id');
        $status = $request->input('status');

        // Create a certificate entry in the database
        Certificate::create([
            'user_id' => $userId,
            'course_id' => $productId,
            'status' => $status,
        ]);

        // Return a success response
        return response()->json(['message' => 'Certificate data has been saved successfully!']);
    }

    public function status(Request $request)
    {
        $id = $request->input('id');
        $status = $request->input('status');

        // Assuming you have a Certificate model
        $certificate = Certificate::find($id);

        if ($certificate) {
            $certificate->status = $status;
            $certificate->save();

            session()->flash('success', 'Certificate status updated successfully!');
            return response()->json(['message' => 'Certificate status updated successfully']);
        }

        session()->flash('error', 'Failed to update certificate status.');
        return response()->json(['message' => 'Certificate not found'], 404);
    }
}
