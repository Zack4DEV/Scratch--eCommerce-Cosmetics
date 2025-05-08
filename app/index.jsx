import { NavigationIndependentTree } from '@react-navigation/native';
import { Tabs } from 'expo-router';
import { MaterialIcons } from '@expo/vector-icons';
import Store from './store';
import Feedback from './feedback';
import AIAssistant from './components/AIAssistant';



export default function AppLayout() {
  return (
    <Tabs screenOptions={{
      tabBarActiveTintColor: '#2E7D32',
      tabBarInactiveTintColor: '#95a5a6',
      headerStyle: {
        backgroundColor: '#2E7D32',
      },
      headerTintColor: '#fff',
    }}>
      <Tabs.Screen
        name="explore"
        options={{
          title: 'Explore',
          tabBarIcon: ({ color }) => (
            <MaterialIcons name="explore" size={24} color={color} />
          ),
        }}
      />
      <Tabs.Screen
        name="store"
        options={{
          title: 'Store',
          tabBarIcon: ({ color }) => (
            <MaterialIcons name="shopping-bag" size={24} color={color} />
          ),
        }}
      />
      {() => (
        <NavigationIndependentTree>
          <Store />
        </NavigationIndependentTree>
      )}
      <Tabs.Screen
        name="ai-guide"
        options={{
          title: 'AI Guide',
          tabBarIcon: ({ color }) => (
            <MaterialIcons name="chat" size={24} color={color} />
          ),
        }}
      />
      {() => (
        <NavigationIndependentTree>
          <AIAssistant />
        </NavigationIndependentTree>
      )}
      <Tabs.Screen
        name="feedback"
        options={{
          title: 'Feedback',
          tabBarIcon: ({ color }) => (
            <MaterialIcons name="star" size={24} color={color} />
          ),
        }}
      />
      {() => (
        <NavigationIndependentTree>
          <Feedback />
        </NavigationIndependentTree>
      )}
      <Tabs.Screen
        name="profile"
        options={{
          title: 'Profile',
          tabBarIcon: ({ color }) => (
            <MaterialIcons name="person" size={24} color={color} />
          ),
        }}
      />
    </Tabs>
  );
}