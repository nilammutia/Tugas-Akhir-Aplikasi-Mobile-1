class Perpustakaan {
  final String id;
  final String nama;
  final String alamat;
  final String telepon;
  final String email;

  Perpustakaan({
    required this.id,
    required this.nama,
    required this.alamat,
    required this.telepon,
    required this.email,
  });

  factory Perpustakaan.fromJson(Map<String, dynamic> json) {
    return Perpustakaan(
      id: json['id'] as String,
      nama: json['nama'] as String,
      alamat: json['alamat'] as String,
      telepon: json['telepon'] as String,
      email: json['email'] as String,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'nama': nama,
      'alamat': alamat,
      'telepon': telepon,
      'email': email,
    };
  }
}
