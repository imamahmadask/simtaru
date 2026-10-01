<?php

namespace Tests\Feature;

use App\Livewire\Admin\Template\TemplateIndex;
use App\Models\DocumentTemplate;
use App\Models\User;
use App\Services\DocumentTemplateService;
use Database\Seeders\DocumentTemplateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Livewire\Livewire;
use Tests\TestCase;

class DocumentTemplateFeatureTest extends TestCase
{
    use RefreshDatabase;

    private User $superadmin;
    private User $surveyor;

    protected function setUp(): void
    {
        parent::setUp();

        Storage::fake('local');

        $this->superadmin = User::factory()->create([
            'role' => 'superadmin',
        ]);

        $this->surveyor = User::factory()->create([
            'role' => 'surveyor',
            'password_changed_at' => now(),
        ]);

        $this->seed(DocumentTemplateSeeder::class);
    }

    public function test_guest_cannot_access_templates_page(): void
    {
        $response = $this->get(route('templates.index'));
        $response->assertRedirect('/');
    }

    public function test_non_superadmin_cannot_access_templates_page(): void
    {
        $response = $this->actingAs($this->surveyor)->get(route('templates.index'));
        $response->assertRedirect('/admin/dashboard');
    }

    public function test_superadmin_can_access_templates_page(): void
    {
        $response = $this->actingAs($this->superadmin)->get(route('templates.index'));
        $response->assertStatus(200);
        $response->assertSee('Dokumen Template');
    }

    public function test_livewire_renders_templates_list(): void
    {
        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->assertStatus(200)
            ->assertSee('1A. Formulir Pemeriksaan Lapangan SKRK')
            ->assertSee('skrk_1a_form_survey');
    }

    public function test_filter_by_module(): void
    {
        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->set('selectedModul', 'skrk')
            ->assertSee('skrk_1a_form_survey')
            ->assertDontSee('pelanggaran_sp1');
    }

    public function test_search_templates(): void
    {
        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->set('search', 'Surat Peringatan 1')
            ->assertSee('pelanggaran_sp1')
            ->assertDontSee('skrk_1a_form_survey');
    }

    public function test_open_and_close_edit_modal(): void
    {
        $template = DocumentTemplate::where('kode', 'skrk_1a_form_survey')->first();

        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->call('openEditModal', $template->id)
            ->assertSet('selectedTemplateId', $template->id)
            ->assertDispatched('open-template-modal')
            ->call('closeEditModal')
            ->assertSet('selectedTemplateId', null)
            ->assertDispatched('close-template-modal');
    }

    public function test_upload_custom_template_successfully(): void
    {
        $template = DocumentTemplate::where('kode', 'skrk_1a_form_survey')->first();

        // Salin file docx asli ke fake upload
        $realDocxContent = file_get_contents(public_path('templates/skrk/1A_Form_Survey_template.docx'));
        $uploadedFile = UploadedFile::fake()->createWithContent(
            'My_Custom_Survey.docx',
            $realDocxContent
        );

        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->call('openEditModal', $template->id)
            ->set('file_template', $uploadedFile)
            ->call('uploadTemplate')
            ->assertHasNoErrors();

        $template->refresh();
        $this->assertNotNull($template->custom_path);
        $this->assertEquals('My_Custom_Survey.docx', $template->original_filename);
        $this->assertEquals($this->superadmin->id, $template->updated_by);
        Storage::disk('local')->assertExists($template->custom_path);
    }

    public function test_reset_custom_template_to_default(): void
    {
        $template = DocumentTemplate::where('kode', 'skrk_1a_form_survey')->first();

        // Buat custom template terlebih dahulu
        $fakePath = 'templates/custom/skrk/test_custom.docx';
        Storage::disk('local')->put($fakePath, 'dummy content');
        $template->update([
            'custom_path' => $fakePath,
            'original_filename' => 'test_custom.docx',
        ]);

        $this->assertTrue($template->isCustom());

        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->call('resetToDefault', $template->id);

        $template->refresh();
        $this->assertNull($template->custom_path);
        $this->assertNull($template->original_filename);
        Storage::disk('local')->assertMissing($fakePath);
    }

    public function test_reject_invalid_file_extension(): void
    {
        $template = DocumentTemplate::where('kode', 'skrk_1a_form_survey')->first();

        $invalidFile = UploadedFile::fake()->create('document.pdf', 500, 'application/pdf');

        Livewire::actingAs($this->superadmin)
            ->test(TemplateIndex::class)
            ->call('openEditModal', $template->id)
            ->set('file_template', $invalidFile)
            ->call('uploadTemplate')
            ->assertHasErrors(['file_template']);
    }
}
