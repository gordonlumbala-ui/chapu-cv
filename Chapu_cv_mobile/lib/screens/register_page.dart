import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import '../services/auth_store.dart';
import '../services/cv_store.dart';
import 'home_page.dart';

class RegisterPage extends StatefulWidget {
  const RegisterPage({super.key});

  @override
  State<RegisterPage> createState() => _RegisterPageState();
}

class _RegisterPageState extends State<RegisterPage> {
  final _formKey = GlobalKey<FormState>();
  final _name = TextEditingController();
  final _email = TextEditingController();
  final _password = TextEditingController();
  final _confirm = TextEditingController();

  @override
  void dispose() {
    _name.dispose();
    _email.dispose();
    _password.dispose();
    _confirm.dispose();
    super.dispose();
  }

  Future<void> _submit() async {
    if (!_formKey.currentState!.validate()) return;

    final auth = context.read<AuthStore>();
    final ok = await auth.register(
      name: _name.text,
      email: _email.text,
      password: _password.text,
      passwordConfirmation: _confirm.text,
    );

    if (!mounted) return;

    if (!ok) {
      ScaffoldMessenger.of(context).showSnackBar(
        SnackBar(content: Text(auth.error ?? 'Registration failed')),
      );
      return;
    }

    await context.read<CvStore>().markStarted();
    if (!mounted) return;

    Navigator.of(context).pushAndRemoveUntil(
      MaterialPageRoute(builder: (_) => const HomePage()),
      (_) => false,
    );
  }

  @override
  Widget build(BuildContext context) {
    final busy = context.watch<AuthStore>().isBusy;

    return Scaffold(
      appBar: AppBar(title: const Text('Create account')),
      body: Form(
        key: _formKey,
        child: ListView(
          padding: const EdgeInsets.fromLTRB(20, 16, 20, 28),
          children: [
            TextFormField(
              controller: _name,
              decoration: const InputDecoration(labelText: 'Full name'),
              validator: (value) =>
                  (value == null || value.trim().isEmpty) ? 'Name is required' : null,
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _email,
              keyboardType: TextInputType.emailAddress,
              decoration: const InputDecoration(labelText: 'Email'),
              validator: (value) =>
                  (value == null || value.trim().isEmpty) ? 'Email is required' : null,
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _password,
              obscureText: true,
              decoration: const InputDecoration(labelText: 'Password'),
              validator: (value) =>
                  (value == null || value.length < 8) ? 'At least 8 characters' : null,
            ),
            const SizedBox(height: 12),
            TextFormField(
              controller: _confirm,
              obscureText: true,
              decoration: const InputDecoration(labelText: 'Confirm password'),
              validator: (value) =>
                  value != _password.text ? 'Passwords do not match' : null,
            ),
            const SizedBox(height: 20),
            FilledButton(
              onPressed: busy ? null : _submit,
              child: busy
                  ? const SizedBox(
                      height: 20,
                      width: 20,
                      child: CircularProgressIndicator(strokeWidth: 2, color: Colors.white),
                    )
                  : const Text('Create account'),
            ),
          ],
        ),
      ),
    );
  }
}
