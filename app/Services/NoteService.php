<?php
namespace App\Services;

use App\Models\Note;
use Illuminate\Http\Request;

class NoteService
{
    public function create(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        return Note::create([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);
    }

    public function getAll()
    {
        return Note::with('category')->get();
    }

    public function get($id)
    {
        return Note::with('category')->find($id);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:categories,id'
        ]);

        $note = Note::find($id);
        if (!$note) {
            return null;
        }

        $note->update([
            'title' => $request->title,
            'description' => $request->description,
            'category_id' => $request->category_id
        ]);

        return $note;
    }

    public function delete($id)
    {
        $note = Note::find($id);
        if (!$note) {
            return null;
        }

        $note->delete();
        return true;
    }
}
