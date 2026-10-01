<?php

namespace Tests\Unit;

use App\Models\DocumentTemplate;
use App\Services\DocumentTemplateService;
use Database\Seeders\DocumentTemplateSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DocumentTemplateServiceTest extends TestCase
{
    use RefreshDatabase;

    private DocumentTemplateService $service;

    protected function setUp(): void
    {
        parent::setUp();

        $this->service = app(DocumentTemplateService::class);
        $this->seed(DocumentTemplateSeeder::class);
    }

    public function test_get_template_by_code(): void
    {
        $template = $this->service->getTemplate('skrk_1a_form_survey');
        $this->assertNotNull($template);
        $this->assertEquals('skrk_1a_form_survey', $template->kode);
        $this->assertEquals('skrk', $template->modul);
    }

    public function test_get_template_by_legacy_path(): void
    {
        $template = $this->service->getTemplate('1A_Form_Survey_template.docx', 'skrk');
        $this->assertNotNull($template);
        $this->assertEquals('skrk_1a_form_survey', $template->kode);
    }

    public function test_get_file_path_returns_existing_disk_file(): void
    {
        $path = $this->service->getFilePath('skrk_1a_form_survey');
        $this->assertFileExists($path);
        $this->assertStringEndsWith('.docx', $path);
    }

    public function test_inspect_file_extracts_variables(): void
    {
        $path = $this->service->getFilePath('skrk_1a_form_survey');
        $inspection = $this->service->inspectFile($path);

        $this->assertTrue($inspection['success']);
        $this->assertGreaterThan(0, $inspection['count']);
        $this->assertContains('nama_pemohon', $inspection['variables']);
        $this->assertContains('alamat_tanah', $inspection['variables']);
    }

    public function test_generate_document_creates_download_response(): void
    {
        $data = [
            'nama_pemohon' => 'Ahmad Suhada',
            'alamat_tanah' => 'Jl. Pendidikan No. 45',
            'kel_tanah' => 'Dasan Agung',
            'kec_tanah' => 'Selaparang',
            'luas_tanah' => '250',
            'fungsi_bangunan' => 'Hunian',
            'batas_barat' => 'Jalan',
            'batas_timur' => 'Tanah Bapak X',
            'batas_utara' => 'Gang',
            'batas_selatan' => 'Rumah',
            'hari_survey' => 'Senin',
            'tgl_survey' => 'Satu',
            'bulan_survey' => 'Januari',
            'tahun_survey' => 'Dua Ribu Dua Puluh Enam',
        ];

        $response = $this->service->generate('skrk_1a_form_survey', $data);

        $this->assertEquals(200, $response->getStatusCode());
        $this->assertStringContainsString('attachment', (string) $response->headers->get('Content-Disposition'));
        $this->assertStringContainsString('.docx', (string) $response->headers->get('Content-Disposition'));
    }
}
