import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../models/cv_data.dart';
import '../services/api_exception.dart';
import '../services/auth_store.dart';
import '../services/cv_store.dart';
import 'cv_preview_page.dart';
import 'login_page.dart';

class CreateCvPage extends StatefulWidget {
  const CreateCvPage({super.key});

  @override
  State<CreateCvPage> createState() => _CreateCvPageState();
}

class _CreateCvPageState extends State<CreateCvPage> {
  final _formKey = GlobalKey<FormState>();
  final _name = TextEditingController();
  final _title = TextEditingController();
  final _email = TextEditingController();
  final _phone = TextEditingController();
  final _location = TextEditingController();
  final _summary = TextEditingController();
  final _experience = TextEditingController();
  final _education = TextEditingController();
  final _skills = TextEditingController();
  bool _seeded = false;
  bool _saving = false;

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (_seeded) return;
    final cv = context.read<CvStore>().cv;
    _name.text = cv.fullName;
    _title.text = cv.jobTitle;
    _email.text = cv.email;
    _phone.text = cv.phone;
    _location.text = cv.location;
    _summary.text = cv.summary;
    _experience.text = cv.experience;
    _education.text = cv.education;
    _skills.text = cv.skills;
    _seeded = true;
  }

  @override
  void dispose() {
    _name.dispose();
    _title.dispose();
    _email.dispose();
    _phone.dispose();
    _location.dispose();
    _summary.dispose();
    _experience.dispose();
    _education.dispose();
    _skills.dispose();
    super.dispose();
  }

  Future<void> _save({bool openPreview = false}) async {
    if (!_formKey.currentState!.validate()) return;

    final auth = context.read<AuthStore>();
    if (!auth.isAuthenticated) {
      final goLogin = await showDialog<bool>(
        context: context,
        builder: (context) => AlertDialog(
          title: const Text('Sign in required'),
          content: const Text(
            'Sign in to save your CV to the Chapu CV server. You can still keep a local draft after cancelling.',
          ),
          actions: [
            TextButton(
              onPressed: () => Navigator.pop(context, false),
              child: const Text('Save offline'),
            ),
            FilledButton(
              onPressed: () => Navigator.pop(context, true),
              child: const Text('Sign in'),
            ),
          ],
        ),
      );

      if (!mounted) return;

      if (goLogin == true) {
        await Navigator.of(context).push(
          MaterialPageRoute(builder: (_) => const LoginPage()),
        );
        if (!mounted) return;
        if (!context.read<AuthStore>().isAuthenticated) return;
      }
    }

    final data = CvData(
      fullName: _name.text.trim(),
      jobTitle: _title.text.trim(),
      email: _email.text.trim(),
      phone: _phone.text.trim(),
      location: _location.text.trim(),
      summary: _summary.text.trim(),
      experience: _experience.text.trim(),
      education: _education.text.trim(),
      skills: _skills.text.trim(),
    );

    setState(() => _saving = true);
    try {
      await context.read<CvStore>().save(
            data,
            authenticated: context.read<AuthStore>().isAuthenticated,
          );
      if (!mounted) return;

      final synced = context.read<AuthStore>().isAuthenticated;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(
          content: Text(synced ? 'CV saved and synced' : 'CV saved on this device'),
        ),
      );

      if (openPreview) {
        Navigator.of(context).pushReplacement(
          MaterialPageRoute(builder: (_) => const CvPreviewPage()),
        );
      } else {
        Navigator.of(context).pop();
      }
    } on ApiException catch (e) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(e.message)),
      );
    } catch (_) {
      if (!mounted) return;
      ScaffoldMessenger.of(context).showSnackBar(
        const SnackBar(content: Text('Could not sync CV. Saved locally instead.')),
      );
    } finally {
      if (mounted) setState(() => _saving = false);
    }
  }

  @override
  Widget build(BuildContext context) {
    return Scaffold(
      appBar: AppBar(title: const Text('Create CV')),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.fromLTRB(20, 8, 20, 28),
          children: [
            _section('Profile'),
            _field(_name, 'Full name', required: true),
            _field(_title, 'Job title'),
            _field(_email, 'Email', keyboard: TextInputType.emailAddress, required: true),
            _field(_phone, 'Phone', keyboard: TextInputType.phone),
            _field(_location, 'Location'),
            _section('Summary'),
            _field(_summary, 'Professional summary', maxLines: 4),
            _section('Experience'),
            _field(
              _experience,
              'Work experience',
              maxLines: 5,
              hint: 'Company — Role — Year\nWhat you achieved…',
            ),
            _section('Education'),
            _field(
              _education,
              'Education',
              maxLines: 4,
              hint: 'School — Degree — Year',
            ),
            _section('Skills'),
            _field(_skills, 'Skills (comma separated)', hint: 'Flutter, Dart, Leadership'),
            const SizedBox(height: 16),
            FilledButton(
              onPressed: _saving ? null : () => _save(openPreview: true),
              child: _saving
                  ? const SizedBox(
                      height: 20,
                      width: 20,
                      child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                    )
                  : const Text('Save & Preview'),
            ),
            const SizedBox(height: 10),
            OutlinedButton(
              onPressed: _saving ? null : () => _save(),
              child: const Text('Save'),
            ),
          ],
        ),
      ),
    );
  }

  Widget _section(String title) {
    return Padding(
      padding: const EdgeInsets.only(top: 16, bottom: 10),
      child: Text(
        title,
        style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16),
      ),
    );
  }

  Widget _field(
    TextEditingController controller,
    String label, {
    bool required = false,
    int maxLines = 1,
    String? hint,
    TextInputType? keyboard,
  }) {
    return Padding(
      padding: const EdgeInsets.only(bottom: 12),
      child: TextFormField(
        controller: controller,
        maxLines: maxLines,
        keyboardType: keyboard,
        validator: required
            ? (value) => (value == null || value.trim().isEmpty) ? 'Required' : null
            : null,
        decoration: InputDecoration(
          labelText: label,
          hintText: hint,
          alignLabelWithHint: maxLines > 1,
        ),
      ),
    );
  }
}
