import sys
import json
import re
import unicodedata
from typing import Optional, Dict
from difflib import get_close_matches
from typing import Tuple, Optional

VALID_CITIES = ["PASURUAN", "SURABAYA", "MALANG", "SIDOARJO", "GRESIK", "JAKARTA"]
VALID_RELIGIONS = ["ISLAM", "KRISTEN", "KATOLIK", "HINDU", "BUDDHA", "KONGHUCU"]
VALID_OCCUPATIONS = [
    "BELUM/TIDAK BEKERJA",
    "MENGURUS RUMAH TANGGA",
    "PELAJAR/MAHASISWA",
    "PENSIUNAN",
    "PEGAWAI NEGERI SIPIL",
    "TENTARA NASIONAL INDONESIA",
    "KEPOLISIAN RI",
    "PERDAGANGAN",
    "PETANI/PEKEBUN",
    "PETERNAK",
    "NELAYAN/PERIKANAN",
    "INDUSTRI",
    "KONSTRUKSI",
    "TRANSPORTASI",
    "KARYAWAN SWASTA",
    "KARYAWAN BUMN",
    "KARYAWAN BUMD",
    "KARYAWAN HONORER",
    "BURUH HARIAN LEPAS",
    "BURUH TANI/PERKEBUNAN",
    "BURUH NELAYAN/PERIKANAN",
    "BURUH PETERNAKAN",
    "PEMBANTU RUMAH TANGGA",
    "TUKANG CUKUR",
    "TUKANG LISTRIK",
    "TUKANG BATU",
    "TUKANG KAYU",
    "TUKANG SOL SEPATU",
    "TUKANG LAS/PANDAI BESI",
    "TUKANG JAHIT",
    "TUKANG GIGI",
    "PENATA RIAS",
    "PENATA BUSANA",
    "PENATA RAMBUT",
    "MEKANIK",
    "SENIMAN",
    "TABIB",
    "PARAJI",
    "PERANCANG BUSANA",
    "PENTERJEMAH",
    "IMAM MESJID",
    "PENDETA",
    "PASTOR",
    "WARTAWAN",
    "USTADZ/MUBALIGH",
    "JURU MASAK",
    "PROMOTOR ACARA",
    "ANGGOTA DPR-RI",
    "ANGGOTA DPD",
    "ANGGOTA BPK",
    "PRESIDEN",
    "WAKIL PRESIDEN",
    "ANGGOTA MAHKAMAH KONSTITUSI",
    "ANGGOTA KABINET/KEMENTERIAN",
    "DUTA BESAR",
    "GUBERNUR",
    "WAKIL GUBERNUR",
    "BUPATI",
    "WAKIL BUPATI",
    "WALIKOTA",
    "WAKIL WALIKOTA",
    "ANGGOTA DPRD PROVINSI",
    "ANGGOTA DPRD KABUPATEN/KOTA",
    "DOSEN",
    "GURU",
    "PILOT",
    "PENGACARA",
    "NOTARIS",
    "ARSITEK",
    "AKUNTAN",
    "KONSULTAN",
    "DOKTER",
    "BIDAN",
    "PERAWAT",
    "APOTEKER",
    "PSIKIATER/PSIKOLOG",
    "PENYIAR TELEVISI",
    "PENYIAR RADIO",
    "PELAUT",
    "PENELITI",
    "SOPIR",
    "PIALANG",
    "PARANORMAL",
    "PEDAGANG",
    "PERANGKAT DESA",
    "KEPALA DESA",
    "PEGAWAI SWASTA",
    "WIRASWASTA",
    "LAINNYA"
]
VALID_PROVINCES = [
    "ACEH", "SUMATERA UTARA", "SUMATERA BARAT", "RIAU", "JAMBI", "SUMATERA SELATAN", 
    "BENGKULU", "LAMPUNG", "KEPULAUAN BANGKA BELITUNG", "KEPULAUAN RIAU", 
    "DKI JAKARTA", "JAWA BARAT", "JAWA TENGAH", "DI YOGYAKARTA", "JAWA TIMUR", 
    "BANTEN", "BALI", "NUSA TENGGARA BARAT", "NUSA TENGGARA TIMUR", "KALIMANTAN BARAT", 
    "KALIMANTAN TENGAH", "KALIMANTAN SELATAN", "KALIMANTAN TIMUR", "KALIMANTAN UTARA", 
    "SULAWESI UTARA", "SULAWESI TENGAH", "SULAWESI SELATAN", "SULAWESI TENGGARA", 
    "GORONTALO", "SULAWESI BARAT", "MALUKU", "MALUKU UTARA", "PAPUA", "PAPUA BARAT",
    "PAPUA SELATAN", "PAPUA TENGAH", "PAPUA PEGUNUNGAN"
]
VALID_KELURAHAN_SURABAYA = [
    # Kecamatan Asemrowo
    "Asemrowo", "Genting Kalianak", "Tambak Sarioso",
    # Kecamatan Benowo
    "Kandangan", "Romokalisari", "Sememi", "Tambak Osowilangun",
    # Kecamatan Bubutan
    "Alun-Alun Contong", "Bubutan", "Gundih", "Jepara", "Tembok Dukuh",
    # Kecamatan Bulak
    "Bulak", "Kedung Cowek", "Kenjeran", "Sukolilo Baru",
    # Kecamatan Dukuh Pakis
    "Dukuh Kupang", "Dukuh Pakis", "Gunung Sari", "Pradah Kalikendal", "Sawunggaling",
    # Kecamatan Gayungan
    "Dukuh Menanggal", "Gayungan", "Ketintang", "Menanggal",
    # Kecamatan Genteng
    "Embong Kaliasin", "Genteng", "Kapasari", "Ketabang", "Peneleh",
    # Kecamatan Gubeng
    "Airlangga", "Baratajaya", "Gubeng", "Kertajaya", "Mojo", "Pucang Sewu",
    # Kecamatan Gunung Anyar
    "Gunung Anyar", "Gunung Anyar Tambak", "Rungkut Menanggal", "Rungkut Tengah",
    # Kecamatan Jambangan
    "Jambangan", "Karah", "Kebonsari", "Pagesangan",
    # Kecamatan Karang Pilang
    "Kebraon", "Karang Pilang", "Warugunung",
    # Kecamatan Kenjeran
    "Bulak Banteng", "Sidotopo Wetan", "Tambak Wedi", "Tanah Kali Kedinding",
    # Kecamatan Krembangan
    "Dupak", "Kemayoran", "Krembangan Selatan", "Morokrembangan", "Perak Barat",
    # Kecamatan Lakarsantri
    "Bangkingan", "Jeruk", "Lakarsantri", "Lidah Kulon", "Lidah Wetan", "Sumur Welut",
    # Kecamatan Mulyorejo
    "Dukuh Sutorejo", "Kalijudan", "Kalisari", "Kejawan Putih Tambak", "Manyar Sabrangan", "Mulyorejo",
    # Kecamatan Pabean Cantian
    "Bongkaran", "Krembangan Utara", "Nyamplungan", "Perak Timur", "Perak Utara",
    # Kecamatan Pakal
    "Babat Jerawat", "Benowo", "Pakal", "Sumber Rejo",
    # Kecamatan Rungkut
    "Kalirungkut", "Kedung Baruk", "Medokan Ayu", "Penjaringansari", "Rungkut Kidul", "Wonorejo",
    # Kecamatan Sambikerep
    "Beringin", "Lontar", "Made", "Sambikerep",
    # Kecamatan Sawahan
    "Banyuurip", "Kupang Krajan", "Pakis", "Petemon", "Putat Jaya", "Sawahan",
    # Kecamatan Semampir
    "Ampel", "Pegirian", "Sidotopo", "Ujung", "Wonokusumo",
    # Kecamatan Simokerto
    "Kapasan", "Sidodadi", "Simokerto", "Simolawang", "Tambakrejo",
    # Kecamatan Sukolilo
    "Gebang Putih", "Keputih", "Klampis Ngasem", "Medokan Semampir", "Menur Pumpungan", "Nginden Jangkungan", "Semolowaru",
    # Kecamatan Sukomanunggal
    "Putat Gede", "Simomulyo", "Simomulyo Baru", "Sonokwijenan", "Sukomanunggal", "Tanjungsari",
    # Kecamatan Tambaksari
    "Dukuh Setro", "Gading", "Kapasmadya Baru", "Pacarkeling", "Pacarkembang", "Ploso", "Rangkah", "Tambaksari",
    # Kecamatan Tandes
    "Balongsari", "Banjar Sugihan", "Karang Poh", "Manukan Kulon", "Manukan Wetan", "Tandes",
    # Kecamatan Tegalsari
    "Dr. Soetomo", "Kedungdoro", "Keputran", "Tegalsari", "Wonorejo",
    # Kecamatan Tenggilis Mejoyo
    "Kendangsari", "Kutisari", "Panjang Jiwo", "Tenggilis Mejoyo",
    # Kecamatan Wiyung
    "Babatan", "Balas Klumprik", "Jajar Tunggal", "Wiyung",
    # Kecamatan Wonocolo
    "Bendul Merisi", "Jemur Wonosari", "Margorejo", "Sidosermo", "Siwalankerto",
    # Kecamatan Wonokromo
    "Darmo", "Jagir", "Ngagel", "Ngagel Rejo", "Sawunggaling", "Wonokromo"
]

def clean_text(text):
    text = unicodedata.normalize("NFKD", text)  
    text = text.replace("\n", " ").replace("\r", " ")  
    text = re.sub(r'[^\w\s:,-]', '', text)  
    text = re.sub(r'\s+', ' ', text).strip()  
    return text

def correct_city_name(city):
    matches = get_close_matches(city.upper(), VALID_CITIES, n=1, cutoff=0.8)
    return matches[0] if matches else city

def normalize_text(text):
    if not text:
        return ""
    text = text.upper().strip()
    text = re.sub(r'\s+', ' ', text)
    text = re.sub(r'[^A-Z]', '', text)  # Hapus semua karakter non-alfabet
    text = text.replace("1", "I").replace("0", "O").replace("5", "S").replace("8", "B")
    text = text.replace("6", "G").replace("7", "T")  # Gantilah angka yang mirip huruf
    return text

def correct_religion(religion):
    if not religion:
        return None
        
    religion = normalize_text(religion)
    
    # Pencocokan kasar terlebih dahulu
    if "SL" in religion or "IS" in religion:
        return "ISLAM"
    elif "KR" in religion or "PR" in religion:  # Dalam OCR, P bisa terbaca sebagai K
        return "KRISTEN"
    elif "KAT" in religion:
        return "KATOLIK"
    elif "HIN" in religion:
        return "HINDU"
    elif "BUD" in religion:
        return "BUDDHA"
    elif "KON" in religion or "KONG" in religion:
        return "KONGHUCU"
    
    # Jika pencocokan kasar gagal, gunakan get_close_matches dengan cutoff yang lebih rendah
    matches = get_close_matches(religion, VALID_RELIGIONS, n=1, cutoff=0.5)
    return matches[0] if matches else religion

def correct_province(province):
    if not province:
        return None
    
    province = province.upper().strip()
    
    # Koreksi umum
    if "JAWA" in province and "TIMUR" in province:
        return "JAWA TIMUR"
    if "JAWA" in province and "BARAT" in province:
        return "JAWA BARAT"
    if "JAWA" in province and "TENGAH" in province:
        return "JAWA TENGAH"
    if "DKI" in province or ("JAKARTA" in province and "PROVINSI" not in province):
        return "DKI JAKARTA"
    
    # Gunakan fuzzy matching
    matches = get_close_matches(province, VALID_PROVINCES, n=1, cutoff=0.7)
    return matches[0] if matches else province

def correct_kelurahan(kelurahan_raw):
    if not kelurahan_raw:
        return None

    kelurahan = normalize_text(kelurahan_raw)

    if "GAJAHBEND" in kelurahan:
        return "GAJAHBENDO"

    # Fuzzy match dengan daftar kelurahan resmi
    matches = get_close_matches(kelurahan, [normalize_text(k) for k in VALID_KELURAHAN_SURABAYA], n=1, cutoff=0.6)

    if matches:
        # Ambil index dari hasil yang di-normalize lalu kembalikan versi aslinya dari daftar resmi
        index = [normalize_text(k) for k in VALID_KELURAHAN_SURABAYA].index(matches[0])
        return VALID_KELURAHAN_SURABAYA[index]
    
    return kelurahan_raw  # fallback jika tidak ada yang cocok

def extract_nik(text: str) -> Optional[str]:
    match = re.search(r'NIK.*?(\d{16})', text, re.IGNORECASE | re.DOTALL)
    if match:
        nik = match.group(1).replace(" ", "").replace("b", "6")
        if len(nik) == 16 and nik.isdigit():
            return nik
    return None

def extract_name(text: str) -> Optional[str]:
    lines = [line.strip() for line in text.splitlines() if line.strip()]
    batas_fields = r'(Tempat|Lahir|Jenis|Alamat|RT|RW|Kel|Desa|Agama|Status|Pekerjaan|Kewarganegaraan|Berlaku|Provinsi|Kabupaten|Kota|Tanggal|Nama|Nomor|NIK|TTL)'

    # 1. Coba cari berdasarkan label Nama
    for i, line in enumerate(lines):
        if re.fullmatch(r'(Nama|Nama Lengkap|Nam[aou])', line, re.IGNORECASE):
            for j in range(1, 3):
                if i + j < len(lines):
                    candidate = lines[i + j].lstrip(": ").strip()
                    if candidate and not re.search(batas_fields, candidate, re.IGNORECASE):
                        return candidate

    # 2. Fallback: setelah NIK (dengan atau tanpa label), cari nama di baris berikutnya
    for i, line in enumerate(lines):
        if re.search(r'\b\d{16}\b', line):
            if i + 1 < len(lines):
                next_line = lines[i + 1].lstrip(": ").strip()
                if re.match(r'^[A-Z][A-Z\s]{2,}$', next_line):
                    return next_line

    return None

def extract_ttl(text: str) -> Tuple[Optional[str], Optional[str]]:
    # 1) “: CITY, DD-MM-YYYY” di awal baris
    m = re.search(
        r'(?m)^\s*:\s*([A-Za-z][A-Za-z\s]+),\s*'    # CITY (huruf & spasi)
        r'(\d{1,2})[-/](\d{1,2})[-/](\d{4})\s*$',   # tanggal
        text
    )
    if m:
        city = m.group(1).strip()
        day = m.group(2).zfill(2)
        month = m.group(3).zfill(2)
        year = m.group(4)
        return city, f"{day}-{month}-{year}"

    # 2) “Tempat/Tgl Lahir” diikuti newline lalu “CITY, DD-MM-YYYY”
    m2 = re.search(
        r'(?is)Tempat\s*/\s*Tgl\s*Lahir\s*[:]\s*\n'     # label + newline
        r'\s*([A-Za-z][A-Za-z\s]+),\s*'                # CITY
        r'(\d{1,2})[-/](\d{1,2})[-/](\d{4})',          # tanggal
        text
    )
    if m2:
        city = m2.group(1).strip()
        day = m2.group(2).zfill(2)
        month = m2.group(3).zfill(2)
        year = m2.group(4)
        return city, f"{day}-{month}-{year}"

    # 3) Cek setiap baris: harus persis “CITY, DD-MM-YYYY”
    for line in text.splitlines():
        m3 = re.match(
            r'^\s*([A-Za-z][A-Za-z\s]+),\s*'     # CITY
            r'(\d{1,2})[-/](\d{1,2})[-/](\d{4})\s*$',  # tanggal
            line
        )
        if m3:
            city = m3.group(1).strip()
            day = m3.group(2).zfill(2)
            month = m3.group(3).zfill(2)
            year = m3.group(4)
            return city, f"{day}-{month}-{year}"

    # 4) Label dan data dalam satu baris, misal: Tempat/Tgl Lahir : CITY, DD-MM-YYYY
    m4 = re.search(
        r'(?i)Tempat\s*/\s*Tgl\s*Lahir\s*[: ]\s*'   # label fleksibel
        r'([A-Za-z\s]+?),\s*'                       # city (non-greedy)
        r'(\d{1,2})[-/](\d{1,2})[-/](\d{4})',       # tanggal
        text
    )
    if m4:
        city = m4.group(1).strip()
        day = m4.group(2).zfill(2)
        month = m4.group(3).zfill(2)
        year = m4.group(4)
        return city, f"{day}-{month}-{year}"

    # 5) Fallback sangat longgar: apapun yang mirip CITY, DD-MM-YYYY
    m5 = re.search(
        r'([A-Za-z\s]{3,}),\s*(\d{1,2})[-/](\d{1,2})[-/](\d{4})',  # minimal 3 huruf utk hindari false positive
        text
    )
    if m5:
        city = m5.group(1).strip()
        day = m5.group(2).zfill(2)
        month = m5.group(3).zfill(2)
        year = m5.group(4)
        return city, f"{day}-{month}-{year}"

    return None, None

def extract_alamat(text):
    # Pertahankan newline untuk bantu segmentasi
    pattern = r'(?:Alamat\s*:?)(.+?)(?:\n|RT|RTRW|RW|Kel|Desa|Kecamatan|Agama|Status|NIK|$)'
    match = re.search(pattern, text, re.IGNORECASE | re.DOTALL)
    if match:
        return match.group(1).replace('\n', ' ').strip(': ').strip()
    return None

def extract_kel_desa(text):
    pattern = r'(?:Kel\/Desa|Kelurahan|Desa)\s*[:|]?\s*(.+?)(?:\n|Kec|Kecamatan|Agama|Status|NIK|$)'
    match = re.search(pattern, text, re.IGNORECASE | re.DOTALL)
    if match:
        value = match.group(1).strip()
        # Validasi supaya bukan noise
        if value != "|" and len(value) >= 3:
            return value.replace('\n', ' ').strip()
    return None

def extract_rt_rw(text):
    patterns = [
        r'RT[\s:/\\|]*0*(\d{1,3})[\s/\-\\|]+RW[\s:/\\|]*0*(\d{1,3})',
        r'RT[\s:/\\|]*0*(\d{1,3})[\s/\-\\|]+0*(\d{1,3})',
        r'\b0*(\d{1,3})[\s/\-\\|]+0*(\d{1,3})\s*(?:Kel|Desa|Kec|$)'
    ]

    for pattern in patterns:
        match = re.search(pattern, text, re.IGNORECASE)
        if match:
            rt = match.group(1).zfill(3)
            rw = match.group(2).zfill(3)
            return rt, rw

    return None, None

def extract_kecamatan(text):
    variations = [
        r'Kecamatan\s*[:\-]?\s*',
        r'Kec[.,]?\s*[:\-]?\s*',
        r'Ke[ck]am[.,]?\s*[:\-]?\s*',
        r'Ke[ck][.]?\s*[:\-]?\s*',
        r'Ke[ce]a[mn][.]?\s*[:\-]?\s*'
    ]

    for pattern in variations:
        kec_match = re.search(
            pattern + r'([A-Z][\w\s\-]+?)(?=\s*(?:Agama|ISLAM|KRISTEN|KATOLIK|BUDDHA|HINDU|KONGHUCU|PROTESTAN|Status|Pekerjaan|Kewarganegaraan|$|\n))',
            text,
            re.IGNORECASE
        )
        if kec_match:
            result = kec_match.group(1).strip()
            # Bersihkan karakter tidak perlu di akhir (seperti "--" atau tanda baca)
            result = re.sub(r'[\W_]+$', '', result)
            return result

    return None

def extract_provinsi(text):
    patterns = [
        r'PROVINSI\s+([\w\s]+?)(?=\s+(?:KABUPATEN|KOTA|KAB|K[O0]TA|NIK|IK)|\n|$)',
        r'PR[O0]V(?:INSI)?\.?\s+([\w\s]+?)(?=\s+(?:KABUPATEN|KOTA|KAB|K[O0]TA|NIK|IK)|\n|$)',
        r'(?:^|\n)([\w\s]+?)(?=\s+(?:KABUPATEN|KOTA|KAB[.]|K[O0]TA))',  # Provinsi di awal baris
    ]
    
    for pattern in patterns:
        provinsi_match = re.search(pattern, text, re.IGNORECASE)
        if provinsi_match:
            raw_province = provinsi_match.group(1).strip()
            return correct_province(raw_province)
    
    # Coba ekstrak dari baris pertama jika ada
    lines = text.split('\n')
    if lines and len(lines) > 0:
        first_line = lines[0].strip()
        if len(first_line.split()) <= 5 and len(first_line) < 30:  # Biasanya provinsi singkat
            if "PROVINSI" in first_line.upper():
                province_part = first_line.upper().replace("PROVINSI", "").strip()
                return correct_province(province_part)
            elif not any(word in first_line.upper() for word in ["NIK", "NAMA", "LAHIR", "KELAMIN"]):
                return correct_province(first_line)
    
    return None

def extract_kabupaten(text):
    patterns = [
        r'(?:KABUPATEN|KAB[.]|KOTA|K[O0]TA)\s+([\w\s]+?)(?=\s+(?:NIK|IK|PROV|NAMA|\d{16})|\n|$)',
        r'(?:^|\n)(?:KABUPATEN|KAB[.]|KOTA|K[O0]TA)\s+([\w\s]+?)(?=\s|\n|$)',  # Di awal baris
    ]
    
    # 1. Cari berdasarkan keyword KOTA/KAB
    for pattern in patterns:
        kabupaten_match = re.search(pattern, text, re.IGNORECASE)
        if kabupaten_match:
            prefix = "KABUPATEN" if re.search(r'KABUPATEN|KAB[.]', text, re.IGNORECASE) else "KOTA"
            nama = kabupaten_match.group(1).strip()
            return f"{prefix} {nama}"
    
    # 2. Fallback: ambil baris setelah 'PROVINSI'
    lines = [line.strip() for line in text.split('\n') if line.strip()]
    for i, line in enumerate(lines):
        if "PROVINSI" in line.upper() and i + 1 < len(lines):
            next_line = lines[i + 1].strip()
            # Validasi: harus huruf semua, bukan label lain, panjang masuk akal
            if (
                5 <= len(next_line) <= 30
                and not re.search(r'(NIK|NAMA|TTL|LAHIR|JENIS|KELAMIN|ALAMAT|RT|RW)', next_line, re.IGNORECASE)
            ):
                return next_line.upper()
    
    return None

def extract_agama(text):
    valid_religions = {"ISLAM", "KRISTEN", "KATOLIK", "HINDU", "BUDDHA"}

    patterns = [
        r'Agama\s*[:1\d\s]*\s*([A-Za-z]+)',
        r'Ag[a@][mn][a@]\s*:?\s*(\w+)',
        r'Ag[ao]m[ao]\s*:?\s*(\w+)',
        r'Ag[.]\s*:?\s*(\w+)',
        r'Ag\s*:?\s*(\w+)'
    ]

    for pattern in patterns:
        agama_match = re.search(pattern, text, re.IGNORECASE)
        if agama_match:
            raw_religion = agama_match.group(1).strip().upper()
            corrected = correct_religion(raw_religion)
            if corrected in valid_religions:
                return corrected

    # Cari kemungkinan agama dalam teks
    for religion in valid_religions:
        if re.search(r'\b' + religion + r'\b', text.upper()):
            return religion

    # Deteksi kesalahan OCR umum
    ocr_errors = {
        "ISL[A4][MW]": "ISLAM", 
        "KR[1I!]ST[E3]N": "KRISTEN",
        "KAT[O0]L[1I!]K": "KATOLIK",
        "H[1I!]ND[U0]": "HINDU",
        "B[U0]DD[HN][A4]": "BUDDHA",
        "KSSLAM": "ISLAM",
        "BUDHA": "BUDDHA"
    }

    for error_pattern, correct in ocr_errors.items():
        if re.search(error_pattern, text.upper()):
            if correct in valid_religions:
                return correct

    return None

def extract_status_perkawinan(text):
    # Cek status eksplisit
    if re.search(r'BELUM\s+KAWIN', text.upper()):
        return 'BELUM KAWIN'
    elif re.search(r'(?:KAWIN|KAWIH|KAWIN|K4WIN)', text.upper()) and not re.search(r'BELUM', text.upper()):
        return 'KAWIN'
    elif re.search(r'CERAI\s+(?:HIDUP|MATI)', text.upper()):
        return 'CERAI'
    
    # Cek dengan pola regex
    patterns = [
        r'Status\s*(?:Perkawinan|Perk|Perka|Prkwn|Prkw)\s*:?\s*([A-Z\s]+?)(?=\s|$|\n)',
        r'Status\s*:?\s*([A-Z\s]+?KAWIN\b)',
        r'Perkawinan\s*:?\s*([A-Z\s]+?)(?=\s|$|\n)'
    ]
    
    for pattern in patterns:
        status_match = re.search(pattern, text, re.IGNORECASE)
        if status_match:
            status = status_match.group(1).strip().upper()
            if "BELUM" in status:
                return "BELUM KAWIN"
            elif "KAWIN" in status:
                return "KAWIN"
            elif "CERAI" in status:
                return "CERAI"
    
    return None

def extract_pekerjaan(text):
    # Normalisasi teks: Ganti \n dengan spasi
    text = text.replace("\\n", " ").replace("\n", " ")
    
    # 1. Coba metode biasa: mencari pola khas untuk pekerjaan
    pattern1 = r'(?:PEKERJAAN|PEKERIAAN|POKORJAAN|PKEKERJAAN|Peokorjaan)[\s\W]*:?\s*([A-Z0-9\s/\(\)\.\-]+?)(?=\s*(?:KEWARGA|CEWARGA|COWARGA|WNI|WNA|BERTAKU|BERLAKU|$))'
    match1 = re.search(pattern1, text, re.IGNORECASE)
    
    if match1 and match1.group(1).strip():
        raw_occupation = match1.group(1).strip()
        # Validasi dengan VALID_OCCUPATIONS
        for valid_occ in VALID_OCCUPATIONS:
            if valid_occ in raw_occupation.upper() or raw_occupation.upper() in valid_occ:
                return valid_occ
    
    # 2. Cari di seluruh teks untuk string yang cocok dengan VALID_OCCUPATIONS
    # Khusus untuk kasus seperti ini, cari "PELAJAR/MAHASISWA" yang tampaknya terlihat di area tertentu
    for valid_occ in VALID_OCCUPATIONS:
        # Cari kesamaan substring yang panjang
        if len(valid_occ) > 10:  # Cukup panjang untuk menghindari false positive
            if valid_occ in text.upper() or valid_occ.replace("/", "") in text.upper():
                return valid_occ
            # Cari variasi dengan spasi yang berbeda
            valid_no_space = valid_occ.replace(" ", "").replace("/", "")
            if valid_no_space in text.upper().replace(" ", ""):
                return valid_occ
    
    # 3. Cek khusus untuk PELAJAR/MAHASISWA di bagian akhir text
    if "PELAJAR" in text.upper() or "MAHASISWA" in text.upper():
        return "PELAJAR/MAHASISWA"
    
    return None

def extract_kewarganegaraan(text):
    patterns = [
        r'Kewarganegaraan\s*:?\s*(WNI|WNA)',
        r'Kwrg[.]?\s*:?\s*(WNI|WNA)',
        r'(?:Warga\s*[nN]egara|WN)\s*:?\s*(Indonesia|Asing|WNI|WNA)',
        r'\b(WNI|WNA)\b'
    ]
    
    for pattern in patterns:
        kewarganegaraan_match = re.search(pattern, text, re.IGNORECASE)
        if kewarganegaraan_match:
            status = kewarganegaraan_match.group(1).strip().upper()
            if status == "INDONESIA" or status == "WNI":
                return "WNI"
            elif status == "ASING" or status == "WNA":
                return "WNA"
    
    # Default untuk Indonesia
    return "WNI"

GOL_DARAH_PATTERN = re.compile(r'Gol\.?\s*Darah\s*:\s*([ABO]+)')
BERLAKU_PATTERN = re.compile(r'Berlaku\s*Hingga\s*:\s*(\d{2}-\d{2}-\d{4})')

def extract_ktp_fields(text: str) -> Dict[str, Optional[str]]:
    # Sanitize input text - remove problematic characters
    text = ''.join(char for char in text if ord(char) < 128 or ord(char) > 159)

    ktp_data = {
        'nik': None, 'nama': None, 'tempat_lahir': None, 'tanggal_lahir': None,
        'jenis_kelamin': None, 'golongan_darah': None, 'alamat_ktp': None,
        'rt_ktp': None, 'rw_ktp': None, 'kel_desa_ktp': None, 'kecamatan_ktp': None,
        'kota_kabupaten_ktp': None, 'provinsi': None, 'agama': None,
        'status_perkawinan': None, 'pekerjaan': None,
        'kewarganegaraan': None, 'berlaku_hingga': None,
        'raw_text': text
    }

    # --- Normal Extraction ---
    nik = extract_nik(text)
    if nik:
        ktp_data["nik"] = nik
    # Nama
    nama = extract_name(text)
    if nama:
        ktp_data['nama'] = nama

    # TTL
    tempat_lahir, tanggal_lahir = extract_ttl(text)
    if tempat_lahir:
        ktp_data['tempat_lahir'] = correct_city_name(tempat_lahir)
    if tanggal_lahir:
        ktp_data['tanggal_lahir'] = tanggal_lahir

    # Jenis Kelamin
    if 'LAKI' in text.upper():
        ktp_data['jenis_kelamin'] = 'LAKI-LAKI'
    elif 'PEREMPUAN' in text.upper():
        ktp_data['jenis_kelamin'] = 'PEREMPUAN'

    # Golongan Darah
    gol_darah_match = GOL_DARAH_PATTERN.search(text)
    if gol_darah_match:
        ktp_data['golongan_darah'] = gol_darah_match.group(1).strip()

    # Alamat
    alamat = extract_alamat(text)
    if alamat:
        ktp_data['alamat_ktp'] = alamat

    # Kelurahan/Desa
    kel_desa = extract_kel_desa(text)
    if kel_desa:
        ktp_data['kel_desa_ktp'] = kel_desa

    # RT/RW
    rt, rw = extract_rt_rw(text)
    if rt: ktp_data['rt_ktp'] = rt
    if rw: ktp_data['rw_ktp'] = rw

    # Kecamatan
    kecamatan = extract_kecamatan(text)
    if kecamatan:
        ktp_data['kecamatan_ktp'] = kecamatan

    # Provinsi
    provinsi = extract_provinsi(text)
    if provinsi:
        ktp_data['provinsi'] = provinsi

    # Kabupaten/Kota
    kabupaten = extract_kabupaten(text)
    if kabupaten:
        ktp_data['kota_kabupaten_ktp'] = kabupaten

    # Agama
    agama = extract_agama(text)
    if agama:
        ktp_data['agama'] = agama

    # Status Perkawinan
    status_perkawinan = extract_status_perkawinan(text)
    if status_perkawinan:
        ktp_data['status_perkawinan'] = status_perkawinan

    # Pekerjaan
    pekerjaan = extract_pekerjaan(text)
    if pekerjaan:
        ktp_data['pekerjaan'] = pekerjaan

    # Kewarganegaraan
    kewarganegaraan = extract_kewarganegaraan(text)
    if kewarganegaraan:
        ktp_data['kewarganegaraan'] = kewarganegaraan

    # Berlaku Hingga
    berlaku_match = BERLAKU_PATTERN.search(text)
    if berlaku_match:
        ktp_data['berlaku_hingga'] = berlaku_match.group(1)

    return ktp_data

def extract_by_ordered_labels(text: str) -> Dict[str, Optional[str]]:
    lines = [line.strip() for line in text.splitlines() if line.strip()]
    result = {}

    labels = [
        "NIK", "Nama", "Tempat/Tgl Lahir", "Jenis kelamin", "Alamat",
        "RT/RW", "Kel/Desa", "Kecamatan", "Agama", "Status Perkawinan",
        "Pekerjaan", "Kewarganegaraan", "Berlaku Hingga"
    ]

    label_indices = []
    for i, line in enumerate(lines):
        if any(label.lower() in line.lower() for label in labels):
            label_indices.append(i)

    # Deteksi pola: semua label muncul berurutan, lalu data-nya menyusul
    if len(label_indices) >= 10 and label_indices == list(range(label_indices[0], label_indices[0] + len(label_indices))):
        # Ambil data setelah semua label
        data_lines = lines[label_indices[-1] + 1:]

        def safe_get(i):
            return data_lines[i].strip() if i < len(data_lines) else None

        result = {
            "nik": re.sub(r'\D', '', safe_get(0) or ''),
            "nama": safe_get(1),
        }

        ttl_line = safe_get(2)
        if ttl_line and ' ' in ttl_line:
            tempat, tanggal = ttl_line.split(' ', 1)
            result["tempat_lahir"] = tempat
            result["tanggal_lahir"] = tanggal

        jk_line = safe_get(3)
        if jk_line:
            if 'LAKI' in jk_line.upper():
                result["jenis_kelamin"] = "LAKI-LAKI"
            elif 'PEREMPUAN' in jk_line.upper():
                result["jenis_kelamin"] = "PEREMPUAN"
            else:
                result["jenis_kelamin"] = jk_line

        result["alamat_ktp"] = safe_get(5)
        rt_rw = safe_get(6)
        if rt_rw and '/' in rt_rw:
            rt, rw = rt_rw.split('/')
            result["rt_ktp"] = rt.strip()
            result["rw_ktp"] = rw.strip()

        result["kel_desa_ktp"] = safe_get(7)
        result["kecamatan_ktp"] = safe_get(8)
        result["agama"] = safe_get(9)
        result["status_perkawinan"] = safe_get(10)
        result["pekerjaan"] = safe_get(11)
        result["kewarganegaraan"] = safe_get(12)
        result["berlaku_hingga"] = safe_get(13)

        # Tambahan jika di akhir ada Provinsi & Kabupaten
        for line in lines:
            if "PROVINSI" in line.upper():
                result["provinsi"] = line.split("PROVINSI")[-1].strip()
            if "KABUPATEN" in line.upper() or "KOTA" in line.upper():
                result["kota_kabupaten_ktp"] = line.strip()

    return result

# === MAIN EXECUTION ===
if __name__ == '__main__':
    try:
        # Path teks diambil dari argumen pertama
        input_path = sys.argv[1]
        # Baca teks mentah hasil OCR dari file dengan explicit encoding
        with open(input_path, 'r', encoding='utf-8', errors='ignore') as f:
            raw_text = f.read()

        # Ekstraksi data KTP
        data = extract_ktp_fields(raw_text)
        
        # Ensure JSON is properly encoded
        json_output = json.dumps(data, ensure_ascii=True)
        print(json_output)
    except Exception as e:
        # Tangani error dan keluarkan dalam JSON
        error_json = json.dumps({'error': str(e)}, ensure_ascii=True)
        print(error_json)
        sys.exit(1)