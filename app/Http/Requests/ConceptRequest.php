<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class ConceptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {

        return [
            'concept_name' => 'required',
            'company'      => 'required',
            'concept_summary' => 'required|string|max:5120',
            'contract_with_robi' => 'required',
            'robi_spoc_id' => 'required',
            'team_id' => 'required',
            'product_proposal' => ['required',File::types(['msg', 'ppt', 'pdf', 'pptx']), 'max:5120'],
            'product_demo_file_url' => ['nullable', 'url'],
            'financial_projection' => [File::types(['msg', 'xlsx', 'ppt', 'xls', 'pdf', 'pptx']), 'max:5120'],
            'ipr_noc_url.*' => ['nullable', File::types(['msg', 'xlsx', 'ppt', 'xls', 'pdf', 'pptx']), 'max:5120'],
            'spoc_name' => 'required',
            'spoc_email' => ['required', 'email'],
            'spoc_mobile' => ['required'],
        ];
    }
}
