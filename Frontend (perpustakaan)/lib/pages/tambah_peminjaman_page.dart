import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'login_page.dart';

class TambahPeminjamanPage extends StatefulWidget {
  @override
  _TambahPeminjamanPageState createState() => _TambahPeminjamanPageState();
}

class _TambahPeminjamanPageState extends State<TambahPeminjamanPage> {
  // controller dan logic lainnya...

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      // 👇 INI bagian appBar yang kamu masukkan
      appBar: AppBar(
        title: Text('Form Peminjaman'),
        actions: [
          IconButton(
            icon: Icon(Icons.logout),
            tooltip: 'Logout',
            onPressed: () async {
              final shouldLogout = await showDialog<bool>(
                context: context,
                builder: (context) => AlertDialog(
                  title: Text('Logout'),
                  content: Text('Apakah kamu yakin ingin logout?'),
                  actions: [
                    TextButton(
                      onPressed: () => Navigator.pop(context, false),
                      child: Text('Batal'),
                    ),
                    ElevatedButton(
                      onPressed: () => Navigator.pop(context, true),
                      child: Text('Logout'),
                    ),
                  ],
                ),
              );

              if (shouldLogout ?? false) {
                final prefs = await SharedPreferences.getInstance();
                await prefs.remove('token');

                Navigator.pushAndRemoveUntil(
                  context,
                  MaterialPageRoute(builder: (_) => LoginPage()),
                  (route) => false,
                );
              }
            },
          ),
        ],
      ),

      // 👇 Body form peminjaman di sini
      body: Padding(
        padding: const EdgeInsets.all(16.0),
        child: Column(
          children: [
            Text('Form Tambah Peminjaman'),
            // Tambahkan field anggota_id, tanggal, buku, dsb.
          ],
        ),
      ),
    );
  }
}

