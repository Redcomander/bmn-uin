<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use App\Models\ActivityLog;
use App\Models\InventoryTable;
use Closure;
use Illuminate\Support\Facades\Auth;

class ActivityLoggerMiddleware
{
    public function handle($request, Closure $next)
    {
        // For other requests, check if the user is authenticated
        if (auth()->check()) {
            // User is authenticated, proceed with logging activity
            if ($request->isMethod('POST') || $request->isMethod('PUT') || $request->isMethod('DELETE')) {
                $user = auth()->user();
                $operation = $request->isMethod('POST') ? 'Create' : ($request->isMethod('PUT') ? 'Update' : 'Delete');
                $model = 'InventoryTable'; // Replace with your model name

                $changes = [];

                if ($request->isMethod('PUT') || $request->isMethod('DELETE')) {
                    $modelInstance = InventoryTable::find($request->route('id')); // Find the updated model
                    if ($modelInstance) {
                        // You can log changes for update and delete operations
                        $originalAttributes = $modelInstance->getOriginal();
                        $changes = array_diff($originalAttributes, $modelInstance->getAttributes());
                    }
                }

                ActivityLog::create([
                    'user_id' => $user->id,
                    'operation' => $operation,
                    'model' => $model,
                    'changes' => json_encode($changes),
                ]);
            }
        } else {
            // User is not authenticated, handle this case as needed
            // For example, you can log unauthorized access attempts or perform other actions.
        }

        return $next($request);
    }



    protected function getModelInstance($request)
    {
        $segments = $request->segments();

        if (count($segments) > 0) {
            // Assuming the last segment is the model's name
            $model = ucfirst($segments[count($segments) - 1]);
            $modelClass = "App\\Models\\" . $model;

            if (class_exists($modelClass)) {
                // Check if the model class exists
                if ($request->has('id')) {
                    // Assuming 'id' is used to identify the model
                    $id = $request->input('id');
                    return $modelClass::find($id);
                }
            }
        }

        return null;
    }


    protected function getChanges($originalAttributes, $newAttributes)
    {
        $changes = [];
        foreach ($newAttributes as $key => $value) {
            if ($originalAttributes[$key] != $value) {
                $changes[$key] = [
                    'old' => $originalAttributes[$key],
                    'new' => $value,
                ];
            }
        }
        return $changes;
    }
}
