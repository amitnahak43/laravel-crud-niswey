<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContactController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $contacts = Contact::all();
        return view('contacts.index', compact('contacts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:contacts,name',
            'phone' => 'required',
        ]);
    
        Contact::create($request->only(['name', 'phone']));
        return redirect()->route('contacts.index')->with('success', 'Contact created.');
    }

    /**
     * Edit the specified resource.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', compact('contact'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $request->validate([
            'name' => 'required|unique:contacts,name,' . $contact->id,
            'phone' => 'required',
        ]);
    
        $contact->update($request->only(['name', 'phone']));
        return redirect()->route('contacts.index')->with('success', 'Contact updated.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();
        return redirect()->route('contacts.index');
    }

    public function importXml(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimetypes:text/plain',
        ]);

        $xml = simplexml_load_file($request->file('xml_file')->getRealPath());

        foreach ($xml->contact as $contact) {
            $name = (string) $contact->name;
            if (!Contact::where('name', $name)->exists()) {
                Contact::create([
                    'name' => (string) $contact->name,
                    'phone' => (string) $contact->phone,
                ]);
            }
        }

        return redirect()->route('contacts.index')->with('success', 'Contacts imported successfully!');
    }
}
