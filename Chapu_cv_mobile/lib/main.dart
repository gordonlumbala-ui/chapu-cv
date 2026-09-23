import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'screens/home_page.dart';
import 'screens/landing_page.dart';
import 'services/api_client.dart';
import 'services/auth_store.dart';
import 'services/cv_store.dart';
import 'theme/app_theme.dart';

void main() {
  WidgetsFlutterBinding.ensureInitialized();
  runApp(const ChapuCvApp());
}

class ChapuCvApp extends StatefulWidget {
  const ChapuCvApp({super.key});

  @override
  State<ChapuCvApp> createState() => _ChapuCvAppState();
}

class _ChapuCvAppState extends State<ChapuCvApp> {
  late final ApiClient _api;
  late final AuthStore _auth;
  late final CvStore _cvStore;

  @override
  void initState() {
    super.initState();
    _api = ApiClient();
    _auth = AuthStore(_api);
    _cvStore = CvStore(_api);
    _bootstrap();
  }

  Future<void> _bootstrap() async {
    await Future.wait([
      _auth.load(),
      _cvStore.load(),
    ]);

    if (_auth.isAuthenticated) {
      await _cvStore.pullFromApi();
    }
  }

  @override
  Widget build(BuildContext context) {
    return MultiProvider(
      providers: [
        ChangeNotifierProvider.value(value: _auth),
        ChangeNotifierProvider.value(value: _cvStore),
      ],
      child: MaterialApp(
        title: 'Chapu CV',
        debugShowCheckedModeBanner: false,
        theme: AppTheme.light(),
        home: AnimatedBuilder(
          animation: Listenable.merge([_auth, _cvStore]),
          builder: (context, _) {
            if (!_auth.isLoaded || !_cvStore.isLoaded) {
              return const Scaffold(
                body: Center(child: CircularProgressIndicator()),
              );
            }

            if (_auth.isAuthenticated || _cvStore.hasStarted) {
              return const HomePage();
            }

            return const LandingPage();
          },
        ),
      ),
    );
  }
}
