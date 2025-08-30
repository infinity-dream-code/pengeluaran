<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplikasi Pengeluaran</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/@supabase/supabase-js@2"></script>
</head>
<body class="bg-gray-100 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Aplikasi Pengeluaran</h1>
                <button id="toggleForm" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                    Tambah Pengeluaran
                </button>
            </div>

            <div id="formSection" class="hidden mb-8 bg-gray-50 p-6 rounded-lg border">
                <h2 class="text-xl font-semibold mb-4 text-gray-700">Tambah Pengeluaran Baru</h2>
                <form id="pengeluaranForm" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal</label>
                        <input type="date" id="tanggal" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Kategori</label>
                        <select id="kategori" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="">Pilih Kategori</option>
                            <option value="Makanan">Makanan</option>
                            <option value="Transport">Transport</option>
                            <option value="Belanja">Belanja</option>
                            <option value="Hiburan">Hiburan</option>
                            <option value="Kesehatan">Kesehatan</option>
                            <option value="Lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Nama Pengeluaran</label>
                        <input type="text" id="nama_pengeluaran" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">Harga</label>
                        <input type="number" id="harga" required class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                    </div>
                    <div class="md:col-span-2 flex gap-2">
                        <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-6 py-2 rounded-lg transition duration-200">
                            Simpan
                        </button>
                        <button type="button" id="cancelForm" class="bg-gray-500 hover:bg-gray-600 text-white px-6 py-2 rounded-lg transition duration-200">
                            Batal
                        </button>
                    </div>
                </form>
            </div>

            <div class="mb-6 flex flex-wrap gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Bulan</label>
                    <select id="filterBulan" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="01">Januari</option>
                        <option value="02">Februari</option>
                        <option value="03">Maret</option>
                        <option value="04">April</option>
                        <option value="05">Mei</option>
                        <option value="06">Juni</option>
                        <option value="07">Juli</option>
                        <option value="08">Agustus</option>
                        <option value="09">September</option>
                        <option value="10">Oktober</option>
                        <option value="11">November</option>
                        <option value="12">Desember</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tahun</label>
                    <select id="filterTahun" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                        <option value="2023">2023</option>
                        <option value="2024">2024</option>
                        <option value="2025">2025</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button id="filterData" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded-lg transition duration-200">
                        Filter
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                    <h3 class="text-lg font-semibold text-blue-800">Total Pengeluaran</h3>
                    <p id="totalPengeluaran" class="text-2xl font-bold text-blue-600">Rp 0</p>
                </div>
                <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                    <h3 class="text-lg font-semibold text-green-800">Kategori Terbesar</h3>
                    <p id="kategoriTerbesar" class="text-lg font-bold text-green-600">-</p>
                </div>
                <div class="bg-yellow-50 p-4 rounded-lg border border-yellow-200">
                    <h3 class="text-lg font-semibold text-yellow-800">Pengeluaran Terbesar</h3>
                    <p id="pengeluaranTerbesar" class="text-lg font-bold text-yellow-600">-</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full bg-white border border-gray-300 rounded-lg">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">ID</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Tanggal</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Kategori</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Nama Pengeluaran</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Harga</th>
                            <th class="px-4 py-3 text-left text-sm font-medium text-gray-700 border-b">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="dataTable">
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-gray-500">Loading data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div id="loading" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden">
        <div class="bg-white p-6 rounded-lg">
            <p class="text-gray-700">Loading...</p>
        </div>
    </div>

    <script>
        const supabaseUrl = 'https://kmggjrnpwhiruxzpqcsf.supabase.co';
        const supabaseKey = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImttZ2dqcm5wd2hpcnV4enBxY3NmIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NTY1NTA2ODgsImV4cCI6MjA3MjEyNjY4OH0.99DLwDjzFZDeRuxnbn8u4BTZhtZbqzIsyIrKI094tKg';
        const supabase = window.supabase.createClient(supabaseUrl, supabaseKey);

        let allData = [];

        function showLoading() {
            document.getElementById('loading').classList.remove('hidden');
        }

        function hideLoading() {
            document.getElementById('loading').classList.add('hidden');
        }

        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR'
            }).format(number);
        }

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID');
        }

        async function loadData() {
            showLoading();
            try {
                const { data, error } = await supabase
                    .from('pengeluaran')
                    .select('*')
                    .order('tanggal', { ascending: false });

                if (error) throw error;
                
                allData = data || [];
                filterAndDisplayData();
            } catch (error) {
                console.error('Error loading data:', error);
                alert('Error loading data: ' + error.message);
            }
            hideLoading();
        }

        function filterAndDisplayData() {
            const bulan = document.getElementById('filterBulan').value;
            const tahun = document.getElementById('filterTahun').value;
            
            const filteredData = allData.filter(item => {
                const itemDate = new Date(item.tanggal);
                const itemBulan = String(itemDate.getMonth() + 1).padStart(2, '0');
                const itemTahun = String(itemDate.getFullYear());
                
                return itemBulan === bulan && itemTahun === tahun;
            });

            displayData(filteredData);
            updateStatistics(filteredData);
        }

        function displayData(data) {
            const tableBody = document.getElementById('dataTable');
            
            if (data.length === 0) {
                tableBody.innerHTML = `
                    <tr>
                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Tidak ada data</td>
                    </tr>
                `;
                return;
            }

            tableBody.innerHTML = data.map(item => `
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 border-b">${item.id}</td>
                    <td class="px-4 py-3 border-b">${formatDate(item.tanggal)}</td>
                    <td class="px-4 py-3 border-b">
                        <span class="px-2 py-1 bg-blue-100 text-blue-800 text-xs rounded-full">${item.kategori}</span>
                    </td>
                    <td class="px-4 py-3 border-b">${item.nama_pengeluaran}</td>
                    <td class="px-4 py-3 border-b font-semibold">${formatRupiah(item.harga)}</td>
                    <td class="px-4 py-3 border-b">
                        <button onclick="deleteItem(${item.id})" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded text-sm transition duration-200">
                            Hapus
                        </button>
                    </td>
                </tr>
            `).join('');
        }

        function updateStatistics(data) {
            const total = data.reduce((sum, item) => sum + item.harga, 0);
            document.getElementById('totalPengeluaran').textContent = formatRupiah(total);

            const kategoriStats = {};
            data.forEach(item => {
                kategoriStats[item.kategori] = (kategoriStats[item.kategori] || 0) + item.harga;
            });

            const kategoriTerbesar = Object.keys(kategoriStats).reduce((a, b) => 
                kategoriStats[a] > kategoriStats[b] ? a : b, '');
            
            if (kategoriTerbesar) {
                document.getElementById('kategoriTerbesar').textContent = 
                    `${kategoriTerbesar} (${formatRupiah(kategoriStats[kategoriTerbesar])})`;
            } else {
                document.getElementById('kategoriTerbesar').textContent = '-';
            }

            const pengeluaranTerbesar = data.reduce((max, item) => 
                item.harga > max.harga ? item : max, { harga: 0, nama_pengeluaran: '-' });
            
            if (pengeluaranTerbesar.harga > 0) {
                document.getElementById('pengeluaranTerbesar').textContent = 
                    `${pengeluaranTerbesar.nama_pengeluaran} (${formatRupiah(pengeluaranTerbesar.harga)})`;
            } else {
                document.getElementById('pengeluaranTerbesar').textContent = '-';
            }
        }

        async function saveData(formData) {
            showLoading();
            try {
                const { data, error } = await supabase
                    .from('pengeluaran')
                    .insert([formData]);

                if (error) throw error;
                
                await loadData();
                document.getElementById('pengeluaranForm').reset();
                document.getElementById('formSection').classList.add('hidden');
                alert('Data berhasil disimpan!');
            } catch (error) {
                console.error('Error saving data:', error);
                alert('Error saving data: ' + error.message);
            }
            hideLoading();
        }

        async function deleteItem(id) {
            if (!confirm('Yakin ingin menghapus data ini?')) return;
            
            showLoading();
            try {
                const { error } = await supabase
                    .from('pengeluaran')
                    .delete()
                    .eq('id', id);

                if (error) throw error;
                
                await loadData();
                alert('Data berhasil dihapus!');
            } catch (error) {
                console.error('Error deleting data:', error);
                alert('Error deleting data: ' + error.message);
            }
            hideLoading();
        }

        document.getElementById('toggleForm').addEventListener('click', function() {
            const formSection = document.getElementById('formSection');
            formSection.classList.toggle('hidden');
        });

        document.getElementById('cancelForm').addEventListener('click', function() {
            document.getElementById('formSection').classList.add('hidden');
            document.getElementById('pengeluaranForm').reset();
        });

        document.getElementById('pengeluaranForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = {
                tanggal: document.getElementById('tanggal').value,
                kategori: document.getElementById('kategori').value,
                nama_pengeluaran: document.getElementById('nama_pengeluaran').value,
                harga: parseInt(document.getElementById('harga').value)
            };
            
            saveData(formData);
        });

        document.getElementById('filterData').addEventListener('click', function() {
            filterAndDisplayData();
        });

        const today = new Date();
        document.getElementById('tanggal').value = today.toISOString().split('T')[0];
        document.getElementById('filterBulan').value = String(today.getMonth() + 1).padStart(2, '0');
        document.getElementById('filterTahun').value = String(today.getFullYear());

        loadData();
    </script>
</body>
</html>