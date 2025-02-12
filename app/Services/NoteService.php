<?php

namespace App\Services;

use App\DTOs\NoteDTO;
use App\DTOs\NoteSearchDTO;
use App\Models\Note;
use App\Repositories\NoteRepository;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;

class NoteService
{
    public function __construct(private NoteRepository $noteRepository) {}

    public function getAll(): LengthAwarePaginator
    {
        Log::info('Fetching all notes');

        $notes = $this->noteRepository->all();

        Log::info('Fetched all notes', ['total' => $notes->total()]);

        return $notes;
    }



    public function search(NoteSearchDTO $dto): LengthAwarePaginator
    {
        Log::info('Searching for notes', ['filters' => $dto->toArray()]);

        $results = $this->noteRepository->search($dto);

        Log::info('Search completed successfully', ['total_found' => $results->total()]);
        return $results;
    }




    public function create(NoteDTO $dto): Note
    {
        Log::info('Creating a new note', ['data' => $dto->toArray()]);

        $note = $this->noteRepository->create($dto->toArray());

        Log::info('Note created successfully successfully', ['id' => $note->id]);
        return $note;
    }



    public function update(Note $note, NoteDTO $dto): Note
    {
        Log::info('Updating note', ['id' => $note->id, 'data' => $dto->toArray()]);

        $updatedNote = $this->noteRepository->update($note, $dto->toArray());

        Log::info('Note updated successfully', ['id' => $updatedNote->id]);
        return $updatedNote;
    }



    public function delete(Note $note): bool
    {
        Log::info('Deleting note', ['id' => $note->id]);

        $deleted = $this->noteRepository->delete($note);

        Log::info('Note deletion status', ['id' => $note->id, 'success' => $deleted]);
        return $deleted;
    }
}
