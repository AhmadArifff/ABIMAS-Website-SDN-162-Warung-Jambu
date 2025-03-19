<?php

use Illuminate\Database\Seeder;

class PendaftaranSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $pendaftaran = new \App\Pendaftaran();
        $pendaftaran->caption = '<p>Untuk mendaftar, harap memenuhi persyaratan berikut:</p><ul><li>Fotokopi KTP atau identitas resmi lainnya.</li><li>Pas foto ukuran 3x4 sebanyak 2 lembar.</li><li>Mengisi formulir pendaftaran yang telah disediakan.</li><li>Melampirkan bukti pembayaran biaya pendaftaran.</li></ul><p>Jika ada pertanyaan lebih lanjut, silakan hubungi kami melalui kontak yang tersedia. Terima kasih.</p>';
        $pendaftaran->image = 'Gambar.png';
        $pendaftaran->save();

        $this->command->info("Pendaftaran berhasil diinsert");
    }
}
